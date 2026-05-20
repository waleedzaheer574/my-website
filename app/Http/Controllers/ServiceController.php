<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('order')->latest()->paginate(10);

        return view('dashboard.services.index', compact('services'));
    }

    public function create()
    {
        return view('dashboard.services.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateService($request);

        $validated['icon'] = $request->hasFile('icon') ? $this->uploadIcon($request) : null;
        $validated['order'] = $validated['order'] ?? 0;

        Service::create($validated);

        return redirect()->route('services.index')->with('success', 'Service added successfully.');
    }

    public function show(Service $service)
    {
        return redirect()->route('services.edit', $service);
    }

    public function edit(Service $service)
    {
        return view('dashboard.services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $this->validateService($request);

        if ($request->hasFile('icon')) {
            $this->deleteFile($service->icon);
            $validated['icon'] = $this->uploadIcon($request);
        } else {
            unset($validated['icon']);
        }

        $validated['order'] = $validated['order'] ?? 0;
        $service->update($validated);

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $this->deleteFile($service->icon);
        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }

    protected function uploadIcon(Request $request): string
    {
        $destination = public_path('uploads/services');

        if (! File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $file = $request->file('icon');
        $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move($destination, $fileName);

        return 'uploads/services/'.$fileName;
    }

    protected function validateService(Request $request): array
    {
        return $request->validate([
            'icon' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:512'],
            'service_title' => ['required', 'string', 'max:255'],
            'service_description' => ['required', 'string'],
            'order' => ['nullable', 'integer', 'min:0'],
        ], [
            'icon.file' => 'The icon must be a JPG, PNG, WEBP, or SVG file.',
            'icon.mimes' => 'The icon must be a JPG, PNG, WEBP, or SVG file.',
            'icon.max' => 'The icon may not be greater than 512 KB.',
        ]);
    }

    protected function deleteFile(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
