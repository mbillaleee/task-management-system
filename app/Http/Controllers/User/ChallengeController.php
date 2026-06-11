<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserChallenge;
use App\Models\Challenge;
use App\Services\GamificationService;

class ChallengeController extends Controller
{
    /**
     * Join a challenge
     * Route: POST /user/challenges/{challenge}/join
     */
    public function join(Challenge $challenge)
    {
        if (! $challenge->is_active) {
            return back()->with('error', 'This challenge is no longer active.');
        }

        if ($challenge->end_date && $challenge->end_date->isPast()) {
            return back()->with('error', 'This challenge has already ended.');
        }

        UserChallenge::firstOrCreate(
            ['user_id' => auth()->id(), 'challenge_id' => $challenge->id],
            ['joined_at' => now()]
        );

        return back()->with('success', 'You joined: ' . $challenge->title . ' 🎯');
    }

    /**
     * Leave a challenge
     * Route: DELETE /user/user-challenges/{userChallenge}/leave
     */
    public function leave(UserChallenge $userChallenge)
    {
        abort_if($userChallenge->user_id !== auth()->id(), 403);

        if ($userChallenge->is_completed) {
            return back()->with('error', 'You cannot leave a completed challenge.');
        }

        $title = $userChallenge->challenge->title;
        $userChallenge->delete();

        return back()->with('success', 'You left: ' . $title);
    }

    /**
     * Manual progress update (শুধু challenge_action = 'manual' হলে এই form দেখাবে)
     * Route: PATCH /user/user-challenges/{userChallenge}/progress
     */
    public function progress(\Illuminate\Http\Request $request, UserChallenge $userChallenge)
    {
        abort_if($userChallenge->user_id !== auth()->id(), 403);

        if ($userChallenge->is_completed) {
            return back()->with('error', 'Challenge already completed.');
        }

        // Auto-action challenge-এ manual input allow করো না
        if ($userChallenge->challenge->challenge_action !== 'manual') {
            return back()->with('error', 'This challenge updates automatically based on your activity.');
        }

        $request->validate(['progress' => 'required|integer|min:1']);

        self::incrementProgress($userChallenge, $request->progress);

        return back()->with('success', 'Progress updated! 💪');
    }

    /**
     * AUTO TRIGGER — অন্য controllers থেকে এটা call করো।
     * challenge_action match হলে সব joined challenges-এ progress বাড়বে।
     *
     * কোথায় কীভাবে call করবে:
     *
     *   TaskController::update()     → ChallengeController::autoProgress(auth()->id(), 'complete_task');
     *   HabitLogController::store()  → ChallengeController::autoProgress(auth()->id(), 'log_habit');
     *   FocusController::complete()  → ChallengeController::autoProgress(auth()->id(), 'finish_focus');
     *   GoalController::update()     → ChallengeController::autoProgress(auth()->id(), 'complete_goal');
     *   JournalController::store()   → ChallengeController::autoProgress(auth()->id(), 'write_journal');
     *   GamificationController::claimDailyReward() → ChallengeController::autoProgress(auth()->id(), 'login_streak');
     */
    public static function autoProgress(int $userId, string $action): void
    {
        // User-এর সব active + incomplete challenges খোঁজো যেগুলো এই action-এ trigger হয়
        $userChallenges = UserChallenge::with('challenge')
            ->where('user_id', $userId)
            ->where('is_completed', false)
            ->whereHas('challenge', function ($q) use ($action) {
                $q->where('challenge_action', $action)
                  ->where('is_active', true);
            })
            ->get();

        foreach ($userChallenges as $uc) {
            self::incrementProgress($uc, 1);
        }
    }

    /**
     * Core increment logic — join/auto/manual সবাই এটা use করে
     */
    private static function incrementProgress(UserChallenge $uc, int $amount): void
    {
        $uc->progress += $amount;

        if ($uc->progress >= $uc->challenge->target_value) {
            $uc->progress     = $uc->challenge->target_value; // cap at target
            $uc->is_completed = true;
            $uc->completed_at = now();
            $uc->save();

            // GamificationService দিয়ে XP দাও
            GamificationService::awardXp(
                $uc->user_id,
                $uc->challenge->xp_reward,
                'Challenge completed: ' . $uc->challenge->title
            );
        } else {
            $uc->save();
        }
    }
}
