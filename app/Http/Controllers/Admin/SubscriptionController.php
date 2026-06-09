<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use App\Models\UserSubscription;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    /* ──────────────────────────────────────────
     *  PLANS
     * ────────────────────────────────────────── */

    public function index()
    {
        $plans = SubscriptionPlan::withCount(['userSubscriptions', 'activeSubscribers'])
            ->ordered()
            ->get();

        $totalSubscribers   = UserSubscription::where('status', 'active')->count();
        $totalRevenue       = UserSubscription::where('status', 'active')->sum('amount_paid');
        $trialUsers         = UserSubscription::where('status', 'trial')->count();
        $cancelledCount     = UserSubscription::where('status', 'cancelled')->count();

        return view('admin.subscriptions.index', compact(
            'plans',
            'totalSubscribers',
            'totalRevenue',
            'trialUsers',
            'cancelledCount',
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'                 => 'required|string|max:100',
            'slug'                 => 'required|string|max:100|unique:subscription_plans,slug',
            'description'          => 'nullable|string',
            'badge_label'          => 'nullable|string|max:50',
            'badge_color'          => 'nullable|string|max:20',
            'price_monthly'        => 'required|numeric|min:0',
            'price_yearly'         => 'required|numeric|min:0',
            'currency'             => 'required|string|max:5',
            'icon'                 => 'nullable|string|max:10',
            'color'                => 'nullable|string|max:20',
            'max_tasks'            => 'nullable|integer|min:-1',
            'max_habits'           => 'nullable|integer|min:-1',
            'max_notes'            => 'nullable|integer|min:-1',
            'max_goals'            => 'nullable|integer|min:-1',
            'max_focus_sessions'   => 'nullable|integer|min:-1',
            'max_journals'         => 'nullable|integer|min:-1',
            'has_analytics'        => 'nullable|boolean',
            'has_calendar'         => 'nullable|boolean',
            'has_gamification'     => 'nullable|boolean',
            'has_themes'           => 'nullable|boolean',
            'has_ai_tools'         => 'nullable|boolean',
            'has_team_workspace'   => 'nullable|boolean',
            'has_priority_support' => 'nullable|boolean',
            'sort_order'           => 'nullable|integer|min:0',
            'is_active'            => 'nullable|boolean',
            'is_featured'          => 'nullable|boolean',
            'features'             => 'nullable|string',   // newline-separated list
        ]);

        // Convert checkbox booleans
        foreach (['has_analytics','has_calendar','has_gamification','has_themes','has_ai_tools','has_team_workspace','has_priority_support','is_active','is_featured'] as $flag) {
            $data[$flag] = $request->boolean($flag);
        }

        // Convert features textarea → JSON array
        if (!empty($data['features'])) {
            $data['features'] = array_filter(array_map('trim', explode("\n", $data['features'])));
        }

        SubscriptionPlan::create($data);

        return back()->with('success', 'Plan "' . $data['name'] . '" created successfully.');
    }

    public function update(Request $request, SubscriptionPlan $subscription)
    {
        $data = $request->validate([
            'name'                 => 'required|string|max:100',
            'slug'                 => 'required|string|max:100|unique:subscription_plans,slug,' . $subscription->id,
            'description'          => 'nullable|string',
            'badge_label'          => 'nullable|string|max:50',
            'badge_color'          => 'nullable|string|max:20',
            'price_monthly'        => 'required|numeric|min:0',
            'price_yearly'         => 'required|numeric|min:0',
            'currency'             => 'required|string|max:5',
            'icon'                 => 'nullable|string|max:10',
            'color'                => 'nullable|string|max:20',
            'max_tasks'            => 'nullable|integer|min:-1',
            'max_habits'           => 'nullable|integer|min:-1',
            'max_notes'            => 'nullable|integer|min:-1',
            'max_goals'            => 'nullable|integer|min:-1',
            'max_focus_sessions'   => 'nullable|integer|min:-1',
            'max_journals'         => 'nullable|integer|min:-1',
            'has_analytics'        => 'nullable|boolean',
            'has_calendar'         => 'nullable|boolean',
            'has_gamification'     => 'nullable|boolean',
            'has_themes'           => 'nullable|boolean',
            'has_ai_tools'         => 'nullable|boolean',
            'has_team_workspace'   => 'nullable|boolean',
            'has_priority_support' => 'nullable|boolean',
            'sort_order'           => 'nullable|integer|min:0',
            'is_active'            => 'nullable|boolean',
            'is_featured'          => 'nullable|boolean',
            'features'             => 'nullable|string',
        ]);

        foreach (['has_analytics','has_calendar','has_gamification','has_themes','has_ai_tools','has_team_workspace','has_priority_support','is_active','is_featured'] as $flag) {
            $data[$flag] = $request->boolean($flag);
        }

        if (isset($data['features'])) {
            $data['features'] = array_filter(array_map('trim', explode("\n", $data['features'])));
        }

        $subscription->update($data);

        return back()->with('success', 'Plan updated successfully.');
    }

    public function destroy(SubscriptionPlan $subscription)
    {
        if ($subscription->activeSubscribers()->count() > 0) {
            return back()->with('error', 'Cannot delete a plan with active subscribers.');
        }

        $subscription->delete();

        return back()->with('success', 'Plan deleted.');
    }

    public function toggleStatus(SubscriptionPlan $subscription)
    {
        $subscription->update(['is_active' => !$subscription->is_active]);
        return back()->with('success', 'Plan status updated.');
    }

    /* ──────────────────────────────────────────
     *  USER SUBSCRIPTIONS
     * ────────────────────────────────────────── */

    public function subscribers()
    {
        $subscriptions = UserSubscription::with(['user', 'plan'])
            ->latest()
            ->paginate(20);

        $plans = SubscriptionPlan::ordered()->get();

        return view('admin.subscriptions.subscribers', compact('subscriptions', 'plans'));
    }

    public function assignPlan(Request $request)
    {
        $data = $request->validate([
            'user_id'              => 'required|exists:users,id',
            'subscription_plan_id' => 'required|exists:subscription_plans,id',
            'billing_cycle'        => 'required|in:monthly,yearly',
            'status'               => 'required|in:active,trial,cancelled,expired',
            'starts_at'            => 'nullable|date',
            'ends_at'              => 'nullable|date',
            'amount_paid'          => 'nullable|numeric|min:0',
            'notes'                => 'nullable|string',
        ]);

        UserSubscription::updateOrCreate(
            ['user_id' => $data['user_id']],
            $data
        );

        return back()->with('success', 'Subscription assigned.');
    }

    public function cancelSubscription(UserSubscription $userSubscription)
    {
        $userSubscription->update([
            'status'       => 'cancelled',
            'cancelled_at' => now(),
        ]);

        return back()->with('success', 'Subscription cancelled.');
    }
}
