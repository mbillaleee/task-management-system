<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\Contact;
use App\Models\NewsletterSubscriber;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function welcome()
    {
        if (auth()->check()) {
            $user = auth()->user();

            if ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->hasRole('user')) {
                return redirect()->route('user.dashboard');
            }
            // Optional: default fallback if role missing
            return redirect()->route('welcome');
        }

        // Guest view
        return view('welcome');
    }

}
