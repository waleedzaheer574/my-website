<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class ServiceDetailController extends Controller
{
    public function index()
    {
        $serviceDetails = ServiceDetail::with('service')->latest()->paginate(10);

        return view('dashboard.service-details.index', compact('serviceDetails'));
    }

    public function create()
    {
        $services = Service::orderBy('service_title')->get();

        return view('dashboard.service-details.create', compact('services'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateDetail($request);
        $validated = $this->prepareDetailData($request, $validated);

        ServiceDetail::create($validated);

        return redirect()->route('service-details.index')->with('success', 'Service detail added successfully.');
    }

    public function show($service_detail)
    {
        $serviceDetail = ServiceDetail::with('service')->findOrFail($service_detail);

        return view('dashboard.service-details.show', compact('serviceDetail'));
    }

    public function edit($service_detail)
    {
        $serviceDetail = ServiceDetail::findOrFail($service_detail);
        $services = Service::orderBy('service_title')->get();

        return view('dashboard.service-details.edit', compact('serviceDetail', 'services'));
    }

    public function update(Request $request, $service_detail)
    {
        $serviceDetail = ServiceDetail::findOrFail($service_detail);
        $validated = $this->validateDetail($request, $serviceDetail);
        $validated = $this->prepareDetailData($request, $validated, $serviceDetail);

        $serviceDetail->update($validated);

        return redirect()->route('service-details.index')->with('success', 'Service detail updated successfully.');
    }

    public function destroy($service_detail)
    {
        $serviceDetail = ServiceDetail::findOrFail($service_detail);
        $this->deleteFile($serviceDetail->primary_image);
        $this->deleteFile($serviceDetail->video_thumbnail);
        $serviceDetail->delete();

        return redirect()->route('service-details.index')->with('success', 'Service detail deleted successfully.');
    }

    public function webIndex()
    {
        $services = Service::with('detail')->orderBy('order')->latest()->get();

        return view('website.service', compact('services'));
    }

    public function webShow(?ServiceDetail $serviceDetail = null)
    {
        if (! $serviceDetail) {
            $serviceDetail = ServiceDetail::with('service')->latest()->firstOrFail();

            if ($serviceDetail->slug) {
                return redirect()->route('website.service-details.show', $serviceDetail->slug, 301);
            }
        }

        $serviceDetail->loadMissing('service');

        return view('website.service-details', compact('serviceDetail'));
    }

    protected function validateDetail(Request $request, ?ServiceDetail $serviceDetail = null): array
    {
        return $request->validate([
            'service_id' => 'nullable|exists:services,id',
            'slug' => 'nullable|string|max:255|unique:service_details,slug,'.($serviceDetail?->id ?? 'NULL'),
            'title_prefix' => 'required|string|max:255',
            'title_highlight' => 'required|string|max:255',
            'description' => 'required|string',
            'process_heading' => 'nullable|string|max:255',
            'process_one_title' => 'nullable|string|max:255',
            'process_one_text' => 'nullable|string',
            'process_two_title' => 'nullable|string|max:255',
            'process_two_text' => 'nullable|string',
            'process_three_title' => 'nullable|string|max:255',
            'process_three_text' => 'nullable|string',
            'primary_image' => ($serviceDetail ? 'nullable' : 'required').'|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'video_thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:1536',
            'video_url' => 'nullable|string|max:255',
        ]);
    }

    protected function prepareDetailData(Request $request, array $validated, ?ServiceDetail $serviceDetail = null): array
    {
        $validated['slug'] = $validated['slug'] ?: Str::slug(trim($validated['title_prefix'].' '.$validated['title_highlight']));

        if ($request->hasFile('primary_image')) {
            $this->deleteFile($serviceDetail?->primary_image);
            $validated['primary_image'] = $this->uploadFile($request->file('primary_image'));
        } else {
            unset($validated['primary_image']);
        }

        if ($request->hasFile('video_thumbnail')) {
            $this->deleteFile($serviceDetail?->video_thumbnail);
            $validated['video_thumbnail'] = $this->uploadFile($request->file('video_thumbnail'));
        } elseif ($serviceDetail) {
            unset($validated['video_thumbnail']);
        } else {
            $validated['video_thumbnail'] = null;
        }

        $validated['video_url'] = $validated['video_url'] ?? null;

        return $validated;
    }

    protected function uploadFile($file): string
    {
        $destination = public_path('uploads/service-details');

        if (! File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move($destination, $fileName);

        return 'uploads/service-details/'.$fileName;
    }

    protected function deleteFile(?string $path): void
    {
        if ($path && File::exists(public_path($path))) {
            File::delete(public_path($path));
        }
    }
}
