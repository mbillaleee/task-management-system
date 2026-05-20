<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServicePackage;
use Illuminate\Http\Request;

class ServicePackageController extends Controller
{
    public function index()
    {
        $data = ServicePackage::with('service')->latest()->paginate(10);

        return view('admin.service-packages.index', compact('data'));
    }

    public function create()
    {
        $services = Service::where('status', true)->orderBy('title')->get();

        return view('admin.service-packages.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'type' => 'required|in:basic,standard,premium',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'delivery_days' => 'nullable|integer|min:0',
            'revisions' => 'nullable|integer|min:0',
            'included' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $included = collect(explode(',', $validated['included'] ?? ''))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();

        ServicePackage::create([
            'service_id' => $validated['service_id'],
            'type' => $validated['type'],
            'title' => $validated['title'],
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'delivery_days' => $validated['delivery_days'] ?? 0,
            'revisions' => $validated['revisions'] ?? 0,
            'included' => $included,
            'status' => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.service-packages.index')
            ->with('success', 'Service package created successfully');
    }

    public function show(ServicePackage $servicePackage)
    {
        $servicePackage->load('service');

        return view('admin.service-packages.show', compact('servicePackage'));
    }

    public function edit(ServicePackage $servicePackage)
    {
        $services = Service::where('status', true)->orderBy('title')->get();

        return view('admin.service-packages.edit', compact('servicePackage', 'services'));
    }

    public function update(Request $request, ServicePackage $servicePackage)
    {
        $validated = $request->validate([
            'service_id' => 'required|exists:services,id',
            'type' => 'required|in:basic,standard,premium',
            'title' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'delivery_days' => 'nullable|integer|min:0',
            'revisions' => 'nullable|integer|min:0',
            'included' => 'nullable|string',
            'status' => 'required|boolean',
        ]);

        $included = collect(explode(',', $validated['included'] ?? ''))
            ->map(fn ($item) => trim($item))
            ->filter()
            ->values()
            ->all();

        $servicePackage->update([
            'service_id' => $validated['service_id'],
            'type' => $validated['type'],
            'title' => $validated['title'],
            'price' => $validated['price'],
            'description' => $validated['description'] ?? null,
            'delivery_days' => $validated['delivery_days'] ?? 0,
            'revisions' => $validated['revisions'] ?? 0,
            'included' => $included,
            'status' => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.service-packages.index')
            ->with('success', 'Service package updated successfully');
    }

    public function destroy(ServicePackage $servicePackage)
    {
        $servicePackage->delete();

        return redirect()->route('admin.service-packages.index')
            ->with('success', 'Service package deleted successfully');
    }
}
