<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\BlogFaq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    public function index()
    {
        $data = Blog::with(['category', 'user'])->latest()->paginate(10);

        return view('admin.blogs.index', compact('data'));
    }

    public function create()
    {
        $categories = BlogCategory::where('status', true)->orderBy('name')->get();

        return view('admin.blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'blog_category_id' => 'required|exists:blog_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'short_description' => 'nullable|string|max:1000',
            'description' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'meta_keywords' => 'nullable|string|max:1000',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'question' => 'nullable|array',
            'answer' => 'nullable|array',
            'sort_order' => 'nullable|array',
        ]);

        $slug = $this->generateUniqueSlug($validated['slug'] ?? '', $validated['title']);

        $blog = new Blog();
        $blog->blog_category_id = $validated['blog_category_id'];
        $blog->user_id = Auth::id();
        $blog->title = $validated['title'];
        $blog->slug  = Str::slug($request->slug);
        $blog->short_description = $validated['short_description'] ?? null;
        $blog->description = $validated['description'];
        $blog->meta_title = $validated['meta_title'] ?? null;
        $blog->meta_description = $validated['meta_description'] ?? null;
        $blog->meta_keywords = $validated['meta_keywords'] ?? null;
        $blog->is_featured = $request->boolean('is_featured', false);
        $blog->status = $validated['status'];
        $blog->published_at = $validated['published_at'] ?? null;
        $blog->views = 0;
        $blog->created_by = Auth::id();
        $blog->updated_by = Auth::id();

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');

            $filename = time() . '_blog.' . $file->getClientOriginalExtension();

            Storage::disk('public')->put('blogs/' . $filename, File::get($file));

            $blog->thumbnail = $filename;
        }

        $blog->save();

        $this->saveFaqs($blog, $request);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog created successfully');
    }

    public function show(Blog $blog)
    {
        $blog->load(['category', 'user', 'faqs']);

        return view('admin.blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        $categories = BlogCategory::where('status', true)->orderBy('name')->get();
        $blog->load(['faqs']);

        return view('admin.blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'blog_category_id' => 'required|exists:blog_categories,id',
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('blogs', 'slug')->ignore($blog->id),
            ],
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'short_description' => 'nullable|string|max:1000',
            'description' => 'required|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'meta_keywords' => 'nullable|string|max:1000',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'question' => 'nullable|array',
            'answer' => 'nullable|array',
            'sort_order' => 'nullable|array',
        ]);

        $slug = $this->generateUniqueSlug($validated['slug'] ?? '', $validated['title'], $blog->id);

        $blog->blog_category_id = $validated['blog_category_id'];
        $blog->title = $validated['title'];
        $blog->slug  = Str::slug($request->slug);
        $blog->short_description = $validated['short_description'] ?? null;
        $blog->description = $validated['description'];
        $blog->meta_title = $validated['meta_title'] ?? null;
        $blog->meta_description = $validated['meta_description'] ?? null;
        $blog->meta_keywords = $validated['meta_keywords'] ?? null;
        $blog->is_featured = $request->boolean('is_featured', false);
        $blog->status = $validated['status'];
        $blog->published_at = $validated['published_at'] ?? null;
        $blog->updated_by = Auth::id();

        if ($request->hasFile('thumbnail')) {
            if ($blog->thumbnail && Storage::disk('public')->exists('blogs/' . $blog->thumbnail)) {
                Storage::disk('public')->delete('blogs/' . $blog->thumbnail);
            }
            $file = $request->file('thumbnail');
            $filename = time() . '_blog.' . $file->getClientOriginalExtension();
            $request->file('thumbnail')->storeAs('blogs', $filename, 'public');
            $blog->thumbnail = $filename;
        }

        $blog->save();

        $blog->faqs()->delete();
        $this->saveFaqs($blog, $request);

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog updated successfully');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->thumbnail && Storage::disk('public')->exists('blogs/' . $blog->thumbnail)) {
            Storage::disk('public')->delete('blogs/' . $blog->thumbnail);
        }

        $blog->faqs()->delete();
        $blog->delete();

        return redirect()->route('admin.blogs.index')
            ->with('success', 'Blog deleted successfully');
    }

    protected function saveFaqs(Blog $blog, Request $request): void
    {
        $questions = $request->input('question', []);
        $answers = $request->input('answer', []);
        $sortOrders = $request->input('sort_order', []);

        foreach ($questions as $index => $question) {
            $question = trim($question);
            $answer = trim($answers[$index] ?? '');

            if ($question === '' && $answer === '') {
                continue;
            }

            $blog->faqs()->create([
                'question' => $question,
                'answer' => $answer,
                'sort_order' => isset($sortOrders[$index]) ? intval($sortOrders[$index]) : 0,
            ]);
        }
    }

    protected function generateUniqueSlug(string $slug, string $title, int $ignoreId = null): string
    {
        $slug = trim($slug) ?: Str::slug($title);

        if (empty($slug)) {
            $slug = Str::random(8);
        }

        $baseSlug = $slug;
        $counter = 1;

        while (Blog::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '<>', $ignoreId))
            ->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
