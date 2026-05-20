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

public function blogs(Request $request)
{
    $query = Blog::with(['category', 'user'])
        ->where('status', 'published')
        ->whereNotNull('published_at')
        ->where('published_at', '<=', now());

    // Search functionality
    if ($request->has('search') && $request->search) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%")
                ->orWhere('short_description', 'like', "%{$search}%");

        });
    }

    // Category filter
    if ($request->has('category') && $request->category) {

        $query->whereHas('category', function ($q) use ($request) {

            $q->where('slug', $request->category);

        });
    }

    $blogs = $query->latest('published_at')->paginate(9);

    // Load categories with published blog count
    $categories = BlogCategory::where('status', 1)
        ->withCount(['blogs' => function ($q) {

            $q->where('status', 'published')
                ->whereNotNull('published_at')
                ->where('published_at', '<=', now());

        }])
        ->get();

    return view('blogs', compact('blogs', 'categories'));
}

    public function blogDetails($slug = null)
    {
        $blog = Blog::with(['category', 'faqs', 'user'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $latestBlogs = Blog::with('user')
            ->where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(5)
            ->get();

        $mostViewedBlogs = Blog::with('user')
            ->where('status', 'published')
            ->where('id', '!=', $blog->id)
            ->orderBy('views', 'desc')
            ->take(5)
            ->get();

        // Load categories with blog count
        $categories = BlogCategory::where('status', 1)
            ->withCount(['blogs' => function ($q) {
                $q->where('status', 'published');
            }])
            ->get();

        $blog->increment('views');

        return view('blog_details', compact(
            'blog',
            'latestBlogs',
            'mostViewedBlogs',
            'categories'
        ));
    }

    public function service(Request $request)
    {
        $query = Service::with(['category', 'packages', 'serviceImages'])->latest();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($categoryId = $request->input('category')) {
            $query->where('service_category_id', $categoryId);
        }

        $services = $query->paginate(9)->withQueryString();

        $categories = ServiceCategory::where('status', true)
            ->withCount(['services as services_count' => function ($q) {
                $q->where('status', 1);
            }])->orderBy('name')->get();

        return view('service', compact('services', 'categories'));
    }

    public function serviceDetails($id)
    {
        // dd($id);
        $service = Service::with(['packages', 'serviceImages', 'category'])
            ->where('id', $id)
            ->firstOrFail();

        return view('service_details', compact('service'));
    }


    public function submit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return redirect()->back()->with('success', 'Message sent successfully!');
    }


     // Subscribe from frontend form
    public function subscribe(Request $request)
    {
        // Validate email
        $validator = \Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:newsletter_subscribers,email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create subscriber
        $subscriber = NewsletterSubscriber::create([
            'email' => $request->email,
            'is_subscribed' => true,
            'subscribed_at' => now(),
            'unsubscribed_at' => null,
            'unsubscribe_token' => \Str::random(32),
        ]);

        // Return success response for AJAX
        return response()->json([
            'status' => 'success',
            'message' => 'You have successfully subscribed!',
            'data' => [
                'id' => $subscriber->id,
                'email' => $subscriber->email,
                'subscribed_at' => $subscriber->subscribed_at,
            ]
        ]);
    }


public function switch($role)
{
    $user = auth()->user();

    // যদি user এর কাছে requested role থাকে
    if($user->hasRole($role)){
        // Set active_role session
        session(['active_role' => $role]);
        return $this->redirectBasedOnRole();
    }

    abort(403, 'Unauthorized');
}

public function redirectBasedOnRole()
{
    $user = Auth::user();

    if (!$user) {
        return redirect()->route('login');
    }

    // Active role session নাও, না থাকলে user এর প্রথম role use করো
    $role = session('active_role') ?? $user->getRoleNames()->first();

    switch ($role) {
        case 'super_admin':
            return redirect()->route('admin.dashboard');
        case 'human_resource':
        case 'hr':
            return redirect()->route('hr.dashboard');
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'employee':
            return redirect()->route('employee.dashboard');
        default:
            return redirect()->route('welcome');
    }
}
}
