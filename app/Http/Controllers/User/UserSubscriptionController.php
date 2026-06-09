<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use Illuminate\Http\Request;

class UserSubscriptionController extends Controller
{
    /**
     * User's subscription page — shows current plan, history, upgrade options.
     * Route: GET /user/subscription
     */
    public function index()
    {
        $user = auth()->user();

        // Current active/trial subscription
        $currentSubscription = UserSubscription::with('plan')
            ->where('user_id', $user->id)
            ->whereIn('status', ['active', 'trial'])
            ->latest()
            ->first();

        // Full subscription history
        $subscriptionHistory = UserSubscription::with('plan')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        // All active plans for upgrade section
        $availablePlans = SubscriptionPlan::active()->ordered()->get();

        // Usage stats
        $usageStats = $this->buildUsageStats($user->id, $currentSubscription?->plan);

        return view('user.subscription.index', compact(
            'currentSubscription',
            'subscriptionHistory',
            'availablePlans',
            'usageStats'
        ));
    }

    /**
     * User requests to upgrade — sends to admin/contact email.
     * (No payment gateway — manual upgrade flow as per project requirement: no external APIs)
     * Route: POST /user/subscription/upgrade-request
     */
    public function upgradeRequest(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
            'message' => 'nullable|string|max:500',
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        $user = auth()->user();

        // Log the upgrade request as a pending subscription record
        UserSubscription::updateOrCreate(
            [
                'user_id' => $user->id,
                'status'  => 'trial',
            ],
            [
                'subscription_plan_id' => $plan->id,
                'billing_cycle'        => $request->get('billing_cycle', 'monthly'),
                'status'               => 'trial',
                'amount_paid'          => 0,
                'starts_at'            => now(),
                'ends_at'              => now()->addDays(7), // 7-day trial
                'notes'                => 'Upgrade request from user. Message: ' . ($request->message ?? '—'),
            ]
        );

        return back()->with('success', 'Your upgrade request for the <strong>' . $plan->name . '</strong> plan has been submitted! Our team will activate it shortly.');
    }

    /**
     * Cancel current subscription — downgrade to free.
     * Route: POST /user/subscription/cancel
     */
    public function cancel(Request $request)
    {
        $user = auth()->user();

        $active = UserSubscription::where('user_id', $user->id)
            ->whereIn('status', ['active', 'trial'])
            ->whereHas('plan', fn($q) => $q->where('price_monthly', '>', 0))
            ->latest()
            ->first();

        if (!$active) {
            return back()->with('error', 'No active paid subscription found.');
        }

        $active->update([
            'status'       => 'cancelled',
            'cancelled_at' => now(),
        ]);

        // Re-assign free plan after cancellation
        $user->assignFreePlan();

        return back()->with('success', 'Your subscription has been cancelled. You have been moved to the Free plan.');
    }

    // ─── Private: build usage stats against plan limits ───────────────────────
    private function buildUsageStats(int $userId, ?SubscriptionPlan $plan): array
    {
        $tasksCount    = \App\Models\Task::where('user_id', $userId)->where('status', '!=', 'completed')->count();
        $habitsCount   = \App\Models\Habit::where('user_id', $userId)->count();
        $notesCount    = \App\Models\Note::where('user_id', $userId)->count();
        $goalsCount    = \App\Models\Goal::where('user_id', $userId)->count();
        $journalsCount = \App\Models\Journal::where('user_id', $userId)->count();

        $focusCount = 0;
        if (class_exists(\App\Models\FocusSession::class)) {
            $focusCount = \App\Models\FocusSession::where('user_id', $userId)->count();
        }

        $mkStat = function (string $label, string $icon, int $used, int $limit) {
            $pct = $limit === -1 ? 0 : ($limit > 0 ? min(100, round($used / $limit * 100)) : 100);
            return compact('label', 'icon', 'used', 'limit', 'pct');
        };

        return [
            $mkStat('Tasks',          '✅', $tasksCount,    $plan?->max_tasks          ?? -1),
            $mkStat('Habits',         '🔥', $habitsCount,   $plan?->max_habits         ?? -1),
            $mkStat('Notes',          '📝', $notesCount,    $plan?->max_notes          ?? -1),
            $mkStat('Goals',          '🎯', $goalsCount,    $plan?->max_goals          ?? -1),
            $mkStat('Focus Sessions', '⏱️', $focusCount,   $plan?->max_focus_sessions ?? -1),
            $mkStat('Journals',       '📖', $journalsCount, $plan?->max_journals       ?? -1),
        ];
    }
}
