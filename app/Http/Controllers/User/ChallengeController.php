<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\UserChallenge;
use App\Models\UserGamification;
use App\Models\Challenge;

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

        UserChallenge::firstOrCreate([
            'user_id'      => auth()->id(),
            'challenge_id' => $challenge->id,
        ]);

        return back()->with('success', 'You joined the challenge: ' . $challenge->title);
    }

    /**
     * Update challenge progress
     * Route: PATCH /user/user-challenges/{userChallenge}/progress
     */
    public function progress(\Illuminate\Http\Request $request, UserChallenge $userChallenge)
    {
        abort_if($userChallenge->user_id !== auth()->id(), 403);

        if ($userChallenge->is_completed) {
            return back()->with('error', 'Challenge already completed.');
        }

        $request->validate([
            'progress' => 'required|integer|min:1',
        ]);

        $userChallenge->progress += $request->progress;

        if ($userChallenge->progress >= $userChallenge->challenge->target_value) {
            $userChallenge->is_completed = true;
            $userChallenge->completed_at = now();

            // Award XP
            $gamification = UserGamification::firstOrCreate(['user_id' => auth()->id()]);
            $gamification->xp    += $userChallenge->challenge->xp_reward;
            $gamification->level  = floor($gamification->xp / 100) + 1;
            $gamification->save();

            $userChallenge->save();

            return back()->with('success', 'Challenge completed! You earned ' . $userChallenge->challenge->xp_reward . ' XP 🏆');
        }

        $userChallenge->save();

        return back()->with('success', 'Progress updated.');
    }
}