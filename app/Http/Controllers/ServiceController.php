<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use App\Models\ServiceImage;
use App\Models\ServicePackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;


class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::with('category')->latest();

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

        $data = $query->paginate(10)->withQueryString();
        $categories = ServiceCategory::where('status', true)->orderBy('name')->get();

        return view('admin.services.index', compact('data', 'categories'));
    }

    public function create()
    {
        $categories = ServiceCategory::where('status', true)->orderBy('name')->get();

        return view('admin.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_category_id' => 'required|exists:service_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:services,slug',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'service_images' => 'nullable|array',
            'service_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'short_description' => 'nullable|string|max:1000',
            'description' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'total_review' => 'nullable|integer|min:0',
            'order_queue' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'meta_keywords' => 'nullable|string|max:1000',
            'packages' => 'nullable|array',
            'packages.*.type' => 'nullable|in:basic,standard,premium',
            'packages.*.title' => 'nullable|string|max:255',
            'packages.*.price' => 'nullable|numeric|min:0',
            'packages.*.description' => 'nullable|string',
            'packages.*.delivery_days' => 'nullable|integer|min:0',
            'packages.*.revisions' => 'nullable|integer|min:0',
            'packages.*.included' => 'nullable|string',
            'packages.*.status' => 'nullable|boolean',
        ]);

        $slug = $this->generateUniqueSlug($validated['slug'] ?? '', $validated['title']);
        

    

        

        $service = Service::create([
            'service_category_id' => $validated['service_category_id'],
            'title' => $validated['title'],
            'slug' => $slug,
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'rating' => $validated['rating'] ?? 5.00,
            'total_review' => $validated['total_review'] ?? 0,
            'order_queue' => $validated['order_queue'] ?? 0,
            'is_featured' => $request->boolean('is_featured', false),
            'status' => $request->boolean('status', true),
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
        ]);


        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $name = time() . '_hero.' . $file->getClientOriginalExtension();
            Storage::disk('public')->put('thumbnail/' . $name, File::get($file));
            $service->update(['thumbnail' => $name]);
        }

        if ($request->hasFile('service_images')) {
            $images = $request->file('service_images');
            if (!empty($images)) {
                foreach ($images as $image) {
                    if ($image && $image->isValid()) {
                        $filename = time() . '_service_image_' . Str::random(6) . '.' . $image->getClientOriginalExtension();
                        Storage::disk('public')->put(
                            'service_images/' . $filename,
                            File::get($image)
                        );
                        ServiceImage::create([
                            'service_id' => $service->id,
                            'image' => $filename,
                            'sort_order' => 0,
                        ]);
                    }
                }
            }
        }


        foreach ($validated['packages'] ?? [] as $packageData) {
            if (empty($packageData['title']) || !isset($packageData['price']) || empty($packageData['type'])) {
                continue;
            }

            ServicePackage::create([
                'service_id' => $service->id,
                'type' => $packageData['type'],
                'title' => $packageData['title'],
                'price' => $packageData['price'],
                'description' => $packageData['description'] ?? null,
                'delivery_days' => $packageData['delivery_days'] ?? 0,
                'revisions' => $packageData['revisions'] ?? 0,
                'included' => array_filter(array_map('trim', explode(',', $packageData['included'] ?? ''))),
                'status' => filter_var($packageData['status'] ?? true, FILTER_VALIDATE_BOOLEAN),
            ]);
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Service created successfully');
    }

    public function show(Service $service)
    {
        $service->load('category');

        return view('admin.services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        $service->load('images', 'packages');
        $categories = ServiceCategory::where('status', true)->orderBy('name')->get();

        return view('admin.services.edit', compact('service', 'categories'));
    }

    public function update(Request $request, Service $service)
    {
        // dd($request->all());
        $validated = $request->validate([
            'service_category_id' => 'required|exists:service_categories,id',
            'title' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('services', 'slug')->ignore($service->id),
            ],
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'service_images' => 'nullable|array',
            'service_images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'short_description' => 'nullable|string|max:1000',
            'description' => 'nullable|string',
            'rating' => 'nullable|numeric|min:0|max:5',
            'total_review' => 'nullable|integer|min:0',
            'order_queue' => 'nullable|integer|min:0',
            'is_featured' => 'nullable|boolean',
            'status' => 'required|boolean',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:1000',
            'meta_keywords' => 'nullable|string|max:1000',
            'packages' => 'nullable|array',
            'packages.*.id' => 'nullable|exists:service_packages,id',
            'packages.*.type' => 'nullable|in:basic,standard,premium',
            'packages.*.title' => 'nullable|string|max:255',
            'packages.*.price' => 'nullable|numeric|min:0',
            'packages.*.description' => 'nullable|string',
            'packages.*.delivery_days' => 'nullable|integer|min:0',
            'packages.*.revisions' => 'nullable|integer|min:0',
            'packages.*.included' => 'nullable|string',
            'packages.*.status' => 'nullable|boolean',
        ]);

        $slug = $this->generateUniqueSlug($validated['slug'] ?? '', $validated['title'], $service->id);
        

      

        $service->update([
            'service_category_id' => $validated['service_category_id'],
            'title' => $validated['title'],
            'slug' => $slug,
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'rating' => $validated['rating'] ?? 5.00,
            'total_review' => $validated['total_review'] ?? 0,
            'order_queue' => $validated['order_queue'] ?? 0,
            'is_featured' => $request->boolean('is_featured', false),
            'status' => $request->boolean('status', true),
            'meta_title' => $validated['meta_title'] ?? null,
            'meta_description' => $validated['meta_description'] ?? null,
            'meta_keywords' => $validated['meta_keywords'] ?? null,
        ]);

        if ($request->hasFile('thumbnail')) {
        if ($service->thumbnail && Storage::disk('public')->exists('thumbnail/' . $service->thumbnail)) {
            Storage::disk('public')->delete('thumbnail/' . $service->thumbnail);
        }
        $file = $request->file('thumbnail');
        $name = time() . '_hero.' . $file->getClientOriginalExtension();
        Storage::disk('public')->put('thumbnail/' . $name, File::get($file));
        $service->update(['thumbnail' => $name]);
        }

        // Remove old images if new images uploaded
        if ($request->hasFile('service_images')) {

            // Delete old images
            foreach ($service->serviceImages as $oldImage) {

                if (
                    !empty($oldImage->image) &&
                    Storage::disk('public')->exists('service_images/' . $oldImage->image)
                ) {

                    Storage::disk('public')->delete('service_images/' . $oldImage->image);
                }

                $oldImage->delete();
            }

            // Upload new images
            $images = $request->file('service_images');

            if (!empty($images)) {

                foreach ($images as $image) {

                    if ($image && $image->isValid()) {

                        $filename = time() . '_service_image_' . Str::random(6) . '.' . $image->getClientOriginalExtension();

                        Storage::disk('public')->put(
                            'service_images/' . $filename,
                            File::get($image)
                        );

                        ServiceImage::create([
                            'service_id' => $service->id,
                            'image' => $filename,
                            'sort_order' => 0,
                        ]);
                    }
                }
            }
        }

        foreach ($validated['packages'] ?? [] as $packageData) {
            if (empty($packageData['title']) || !isset($packageData['price']) || empty($packageData['type'])) {
                continue;
            }

            $data = [
                'service_id' => $service->id,
                'type' => $packageData['type'],
                'title' => $packageData['title'],
                'price' => $packageData['price'],
                'description' => $packageData['description'] ?? null,
                'delivery_days' => $packageData['delivery_days'] ?? 0,
                'revisions' => $packageData['revisions'] ?? 0,
                'included' => array_filter(array_map('trim', explode(',', $packageData['included'] ?? ''))),
                'status' => filter_var($packageData['status'] ?? true, FILTER_VALIDATE_BOOLEAN),
            ];

            if (!empty($packageData['id'])) {
                $package = ServicePackage::where('id', $packageData['id'])->where('service_id', $service->id)->first();
                if ($package) {
                    $package->update($data);
                    continue;
                }
            }

            ServicePackage::create($data);
        }

        return redirect()->route('admin.services.index')
            ->with('success', 'Service updated successfully');
    }

    public function destroy(Service $service)
    {
        if ($service->thumbnail && Storage::disk('public')->exists('services/' . $service->thumbnail)) {
            Storage::disk('public')->delete('services/' . $service->thumbnail);
        }

        $service->delete();

        return redirect()->route('admin.services.index')
            ->with('success', 'Service deleted successfully');
    }

    protected function generateUniqueSlug(string $slug, string $title, int $ignoreId = null): string
    {
        $slug = trim($slug) ?: Str::slug($title);

        if (empty($slug)) {
            $slug = Str::random(8);
        }

        $baseSlug = $slug;
        $counter = 1;

        while (Service::where('slug', $slug)
            ->when($ignoreId, fn ($query) => $query->where('id', '<>', $ignoreId))
            ->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
