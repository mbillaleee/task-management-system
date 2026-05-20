<?php

namespace App\Http\Controllers;

use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Str;
use Illuminate\Validation\Rule;

class ServiceCategoryController extends Controller
{
    public function index()
    {
        $data = ServiceCategory::latest()->paginate(40);

        return view('admin.service-categories.index', compact('data'));
    }

    public function create()
    {
        return view('admin.service-categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:service_categories,slug',
            'status' => 'required|boolean',
        ]);

        $slug = $this->generateUniqueSlug($validated['slug'] ?? '', $validated['name']);

        ServiceCategory::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'status' => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.service-categories.index')
            ->with('success', 'Service category created successfully');
    }

    public function show(ServiceCategory $serviceCategory)
    {
        return redirect()->route('admin.service-categories.index');
    }

    public function edit(ServiceCategory $serviceCategory)
    {
        return view('admin.service-categories.edit', compact('serviceCategory'));
    }

    public function update(Request $request, ServiceCategory $serviceCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('service_categories', 'slug')->ignore($serviceCategory->id),
            ],
            'status' => 'required|boolean',
        ]);

        $slug = $this->generateUniqueSlug($validated['slug'] ?? '', $validated['name'], $serviceCategory->id);

        $serviceCategory->update([
            'name' => $validated['name'],
            'slug' => $slug,
            'status' => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.service-categories.index')
            ->with('success', 'Service category updated successfully');
    }

    public function destroy(ServiceCategory $serviceCategory)
    {
        $serviceCategory->delete();

        return redirect()->route('admin.service-categories.index')
            ->with('success', 'Service category deleted successfully');
    }

    protected function generateUniqueSlug(string $slug, string $name, int $ignoreId = null): string
    {
        $slug = trim($slug) ?: Str::slug($name);

        if (empty($slug)) {
            $slug = Str::random(8);
        }

        $baseSlug = $slug;
        $counter = 1;

        while (ServiceCategory::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '<>', $ignoreId))
            ->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
