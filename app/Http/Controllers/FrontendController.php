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
        return view('welcome');
    }

    public function about()
    {
        $departments = Department::with(['users' => function ($query) {
            $query->orderBy('id', 'asc');
        }])->get();

        return view('about', compact('departments'));
    }

    public function contact()
    {
        return view('contact');
    }



}
