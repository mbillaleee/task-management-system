<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Language;

class SetLocale
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // 1. Try session first
        $locale = Session::get('locale');

        // 2. Fallback to logged-in user preference
        if (!$locale && Auth::check() && !empty(Auth::user()->locale)) {
            $locale = Auth::user()->locale;
        }

        // 3. Validate locale exists in database and is active
        if ($locale) {
            $language = Language::where('language_code', $locale)
                                ->where('active', 1)
                                ->first();
            if ($language) {
                $locale = $language->language_code;
            } else {
                $locale = null; // invalidate invalid locale
            }
        }

        // 4. Fallback to default app locale if still null
        if (!$locale) {
            $locale = config('app.locale', 'en');
        }

        // 5. Set Laravel locale
        App::setLocale($locale);

        // 6. Set PHP locale for date/time formatting (optional)
        setlocale(LC_TIME, $locale);

        // 7. Save final locale into session
        Session::put('locale', $locale);

        return $next($request);
    }
}