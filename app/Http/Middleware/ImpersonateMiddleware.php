<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\User;

class ImpersonateMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // If impersonating, show the stop-impersonating banner via shared variable
        if (Session::has('impersonate.original_admin_id')) {
            $adminId = Session::get('impersonate.original_admin_id');
            $admin   = User::find($adminId);
            view()->share('impersonating', true);
            view()->share('impersonatingAdmin', $admin);
        } else {
            view()->share('impersonating', false);
            view()->share('impersonatingAdmin', null);
        }

        return $next($request);
    }
}
