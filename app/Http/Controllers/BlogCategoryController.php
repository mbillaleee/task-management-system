<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BlogCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = BlogCategory::latest()->paginate(40);

        return view('admin.blog_category.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.blog-categories.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:blog_categories,slug',
            'status' => 'nullable|boolean',
        ]);

        $slug = $this->generateUniqueSlug($validated['slug'] ?? '', $validated['name']);

        BlogCategory::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'status' => $request->boolean('status', true),
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Blog category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(BlogCategory $blogCategory)
    {
        return redirect()->route('admin.blog-categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BlogCategory $blogCategory)
    {
        return redirect()->route('admin.blog-categories.index');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BlogCategory $blogCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('blog_categories', 'slug')->ignore($blogCategory->id),
            ],
            'status' => 'nullable|boolean',
        ]);

        $slug = $this->generateUniqueSlug($validated['slug'] ?? '', $validated['name'], $blogCategory->id);

        $blogCategory->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'status' => $request->boolean('status', true),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Blog category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BlogCategory $blogCategory)
    {
        $blogCategory->delete();

        return redirect()->route('admin.blog-categories.index')
            ->with('success', 'Blog category deleted successfully');
    }

    /**
     * Generate a unique slug for the blog category.
     */
    protected function generateUniqueSlug(string $slug, string $name, int $ignoreId = null): string
    {
        $slug = trim($slug) ?: Str::slug($name);

        if (empty($slug)) {
            $slug = Str::random(8);
        }

        $baseSlug = $slug;
        $counter = 1;

        while (BlogCategory::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '<>', $ignoreId))
            ->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
