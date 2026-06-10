<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\Password;

class SettingsController extends Controller
{
    /** Show settings page — default tab passed via query string ?tab=account */
    public function index(Request $request)
    {
        $user        = $request->user();
        $tab         = $request->get('tab', 'account');
        $subscription = \App\Models\UserSubscription::with('plan')
            ->where('user_id', $user->id)
            ->whereIn('status', ['active', 'trial'])
            ->latest()->first();

        return view('user.settings.index', compact('user', 'tab', 'subscription'));
    }

    /* ──────────────────────────────────────────
     *  TAB 1 — ACCOUNT (name, email, photo, bio…)
     * ────────────────────────────────────────── */
    public function updateAccount(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $data = $request->validate([
            'name'          => 'required|string|max:100',
            'username'      => 'nullable|string|max:60|unique:users,username,' . $user->id,
            'email'         => 'required|email|max:150|unique:users,email,' . $user->id,
            'bio'           => 'nullable|string|max:300',
            'phone'         => 'nullable|string|max:30',
            'gender'        => 'nullable|in:male,female,non-binary,prefer_not',
            'date_of_birth' => 'nullable|date|before:today',
            'country'       => 'nullable|string|max:100',
            'city'          => 'nullable|string|max:100',
            'timezone'      => 'nullable|string|max:60',
            'profile'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // Handle email change → reset verification
        if ($user->email !== $data['email']) {
            $user->email_verified_at = null;
        }

        // Avatar upload
        if ($request->hasFile('profile')) {
            if ($user->profile && Storage::disk('public')->exists('profile/' . $user->profile)) {
                Storage::disk('public')->delete('profile/' . $user->profile);
            }
            $file        = $request->file('profile');
            $filename    = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('profile/' . $filename, File::get($file));
            $data['profile'] = $filename;
        }

        $user->fill($data)->save();

        return back()->with('tab', 'account')->with('success', 'Account updated successfully.');
    }

    /** Change password */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        Auth::user()->update(['password' => Hash::make($request->password)]);

        return back()->with('tab', 'account')->with('success', 'Password changed successfully.');
    }

    /* ──────────────────────────────────────────
     *  TAB 2 — APPEARANCE
     * ────────────────────────────────────────── */
    public function updateAppearance(Request $request): RedirectResponse
    {
        $request->validate([
            'theme'           => 'required|in:dark,light',
            'accent_color'    => 'nullable|string|max:20',
            'language'        => 'nullable|string|max:10',
            'sidebar_compact' => 'nullable|boolean',
        ]);

        Auth::user()->update([
            'theme'           => $request->theme,
            'accent_color'    => $request->accent_color ?? '#f97316',
            'language'        => $request->language ?? 'en',
            'sidebar_compact' => $request->boolean('sidebar_compact'),
        ]);

        // Also persist language in session so translate() picks it up
        session(['locale' => $request->language ?? 'en']);

        return back()->with('tab', 'appearance')->with('success', 'Appearance saved.');
    }

    /* ──────────────────────────────────────────
     *  TAB 3 — NOTIFICATIONS
     * ────────────────────────────────────────── */
    public function updateNotifications(Request $request): RedirectResponse
    {
        Auth::user()->update([
            'notif_task_reminders'  => $request->boolean('notif_task_reminders'),
            'notif_habit_reminders' => $request->boolean('notif_habit_reminders'),
            'notif_goal_updates'    => $request->boolean('notif_goal_updates'),
            'notif_weekly_report'   => $request->boolean('notif_weekly_report'),
            'notif_xp_rewards'      => $request->boolean('notif_xp_rewards'),
            'notif_email'           => $request->boolean('notif_email'),
        ]);

        return back()->with('tab', 'notifications')->with('success', 'Notification preferences saved.');
    }

    /* ──────────────────────────────────────────
     *  TAB 4 — PRIVACY & SECURITY
     * ────────────────────────────────────────── */
    public function updatePrivacy(Request $request): RedirectResponse
    {
        Auth::user()->update([
            'profile_public'     => $request->boolean('profile_public'),
            'show_streak'        => $request->boolean('show_streak'),
            'show_xp'            => $request->boolean('show_xp'),
            'two_factor_enabled' => $request->boolean('two_factor_enabled'),
        ]);

        return back()->with('tab', 'privacy')->with('success', 'Privacy settings saved.');
    }

    /* ──────────────────────────────────────────
     *  DELETE ACCOUNT
     * ────────────────────────────────────────── */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('success', 'Account deleted.');
    }
}
