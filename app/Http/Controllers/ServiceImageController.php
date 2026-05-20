<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceImageController extends Controller
{
    public function index()
    {
        $data = ServiceImage::with('service')->latest()->paginate(10);

        return view('admin.service-images.index', compact('data'));
    }

    public function create()
    {
        $services = Service::where('status', true)->orderBy('title')->get();

        return view('admin.service-images.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $file = $request->file('image');
        $filename = time() . '_service_image.' . $file->getClientOriginalExtension();
        $file->storeAs('service_images', $filename, 'public');

        ServiceImage::create([
            'service_id' => $validated['service_id'],
            'image' => $filename,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.service-images.index')
            ->with('success', 'Service image created successfully');
    }

    public function show(ServiceImage $serviceImage)
    {
        $serviceImage->load('service');

        return view('admin.service-images.show', compact('serviceImage'));
    }

    public function edit(ServiceImage $serviceImage)
    {
        $services = Service::where('status', true)->orderBy('title')->get();

        return view('admin.service-images.edit', compact('serviceImage', 'services'));
    }

    public function update(Request $request, ServiceImage $serviceImage)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $imageName = $serviceImage->image;

        if ($request->hasFile('image')) {
            if ($serviceImage->image && Storage::disk('public')->exists('service_images/' . $serviceImage->image)) {
                Storage::disk('public')->delete('service_images/' . $serviceImage->image);
            }

            $file = $request->file('image');
            $imageName = time() . '_service_image.' . $file->getClientOriginalExtension();
            $file->storeAs('service_images', $imageName, 'public');
        }

        $serviceImage->update([
            'service_id' => $validated['service_id'],
            'image' => $imageName,
            'sort_order' => $validated['sort_order'] ?? 0,
        ]);

        return redirect()->route('admin.service-images.index')
            ->with('success', 'Service image updated successfully');
    }

    public function destroy(ServiceImage $serviceImage)
    {
        if ($serviceImage->image && Storage::disk('public')->exists('service_images/' . $serviceImage->image)) {
            Storage::disk('public')->delete('service_images/' . $serviceImage->image);
        }

        $serviceImage->delete();

        return redirect()->route('admin.service-images.index')
            ->with('success', 'Service image deleted successfully');
    }
}
