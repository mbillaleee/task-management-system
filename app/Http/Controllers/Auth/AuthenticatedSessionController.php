<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    // public function store(LoginRequest $request): RedirectResponse
    // {
    //     $request->authenticate();
    //     $request->session()->regenerate(); 
    //     return redirect()->intended(route('admin.dashboard', absolute: false));
    // }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = auth()->user();

        // Default active role = highest priority
        if($user->hasRole('super_admin')) {
            $activeRole = 'super_admin';
        } elseif($user->hasRole('admin')) {
            $activeRole = 'admin';
        } elseif($user->hasRole('employee')) {
            $activeRole = 'employee';
        } else {
            $activeRole = 'user';
        }

        session(['active_role' => $activeRole]);

        return $this->redirectBasedOnRole($activeRole);
    }

    protected function redirectBasedOnRole($role)
    {
        switch($role) {
            case 'super_admin':
                return redirect()->route('admin.dashboard');
            case 'human_resource':
                return redirect()->route('hr.dashboard');
            case 'employee':
                return redirect()->route('employee.dashboard');
            default:
                return redirect()->route('welcome');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
