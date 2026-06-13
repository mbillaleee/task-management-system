<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserGamification;
use App\Models\UserSubscription;
use App\Models\SubscriptionPlan;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    /**
     * Display a listing of users with filters & search.
     */
    public function index(Request $request)
    {
        $query = User::with('roles', 'activeSubscription.plan', 'gamification');

        // Search
        if ($request->filled('search')) {
            $q = $request->search;
            $query->where(function ($qb) use ($q) {
                $qb->where('name', 'like', "%{$q}%")
                   ->orWhere('email', 'like', "%{$q}%");
            });
        }

        // Role filter
        if ($request->filled('role')) {
            $query->whereHas('roles', fn($r) => $r->where('name', $request->role));
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $data  = $query->latest()->paginate(15)->withQueryString();
        $roles = Role::all();

        // Stats
        $totalUsers    = User::count();
        $activeUsers   = User::where('status', 1)->count();
        $suspendedUsers = User::where('status', 0)->count();
        $newThisMonth  = User::where('created_at', '>=', now()->startOfMonth())->count();

        return view('admin.users.index', compact(
            'data', 'roles', 'totalUsers', 'activeUsers', 'suspendedUsers', 'newThisMonth'
        ));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a new user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'             => 'required|string|max:255',
            'email'            => 'required|email|unique:users,email',
            'password'         => 'required|min:6|same:confirm-password',
            'role'             => 'required',
            'status'           => 'nullable|in:1,0',
            'profile'          => 'nullable|image|max:2048',
        ]);

        $user = new User();
        $user->name     = $request->name;
        $user->email    = $request->email;
        $user->status   = $request->input('status', 1);
        $user->password = Hash::make($request->password);

        if ($request->hasFile('profile')) {
            $file = $request->file('profile');
            $name = time() . '_hero.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('profile/' . $name, File::get($file));
            $user->profile = $name;
        }

        $user->save();
        $user->assignRole($request->role);

        // Auto assign free plan
        $user->assignFreePlan();

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Show user detail with XP, Level, Streak, Subscription.
     */
    public function show(string $id)
    {
        $user = User::with([
            'roles',
            'gamification',
            'activeSubscription.plan',
            'subscriptions.plan',
            'badges',
            'tasks',
            'habits',
            'notes',
            'goals',
            'journals',
        ])->findOrFail($id);

        $userRole       = $user->roles->pluck('name', 'name')->all();
        $gamification   = $user->gamification;

        return view('admin.users.show', compact('user', 'userRole', 'gamification'));
    }

    /**
     * Show edit form.
     */
    public function edit(string $id)
    {
        $user     = User::findOrFail($id);
        $roles    = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update user.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|min:6|same:confirm-password',
            'role'    => 'required',
            'status'  => 'nullable|in:1,0',
            'profile' => 'nullable|image|max:2048',
        ]);

        $user = User::findOrFail($id);
        $user->name   = $request->name;
        $user->email  = $request->email;
        $user->status = $request->input('status', $user->status);

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('profile')) {
            if ($user->profile && Storage::disk('public')->exists('profile/' . $user->profile)) {
                Storage::disk('public')->delete('profile/' . $user->profile);
            }
            $file = $request->file('profile');
            $name = time() . '_hero.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('profile/' . $name, File::get($file));
            $user->profile = $name;
        }

        $user->save();

        DB::table('model_has_roles')->where('model_id', $id)->delete();
        $user->assignRole($request->role);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    /**
     * Delete user.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Prevent self-delete
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // EXTRA ADMIN ACTIONS
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Toggle suspend / activate user.
     */
    public function toggleStatus(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot suspend your own account.');
        }

        $user->status = $user->status == 1 ? 0 : 1;
        $user->save();

        $msg = $user->status == 1 ? 'User activated successfully.' : 'User suspended successfully.';

        return back()->with('success', $msg);
    }

    /**
     * Reset user password from admin panel.
     */
    public function resetPassword(Request $request, string $id)
    {
        $request->validate([
            'new_password'              => 'required|min:6|same:new_password_confirmation',
            'new_password_confirmation' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password reset successfully.');
    }

    /**
     * Impersonate a user — login as that user.
     */
    public function impersonate(string $id)
    {
        $target = User::findOrFail($id);

        if ($target->hasRole('super_admin')) {
            return back()->with('error', 'Cannot impersonate another admin.');
        }

        // Save original admin ID in session
        Session::put('impersonate.original_admin_id', Auth::id());

        Auth::login($target);

        return redirect()->route('user.dashboard')
            ->with('info', 'You are now logged in as ' . $target->name . '. Click "Stop Impersonating" to go back.');
    }

    /**
     * Stop impersonating — return to admin account.
     */
    public function stopImpersonate()
    {
        $adminId = Session::pull('impersonate.original_admin_id');

        if (!$adminId) {
            return redirect()->route('admin.dashboard');
        }

        $admin = User::findOrFail($adminId);
        Auth::login($admin);

        return redirect()->route('admin.users.index')
            ->with('success', 'Returned to your admin account.');
    }
}
