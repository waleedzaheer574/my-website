<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CompanySettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $settings = CompanySetting::all();

        return view('dashboard.settings.index', compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.settings.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'phone' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:30',
            'quote_link' => 'nullable|string|max:255',
            'fax' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'email' => 'nullable|email|max:255',
            'smtp_email' => 'nullable|email|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'notification_email' => 'nullable|email|max:255',
            'instagram' => 'nullable|url',
            'pinterest' => 'nullable|url',
            'facebook' => 'nullable|url',
            'youtube' => 'nullable|url',
            'tiktok' => 'nullable|url',
            'linkedin' => 'nullable|url',
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('logos', 'public');
            $this->syncPublicStorageFile($path);
            $data['logo'] = $path;
        }

        CompanySetting::create($data);

        return redirect()->route('settings.index')->with('success', 'Setting created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(CompanySetting $setting)
    {
        return view('dashboard.settings.show', compact('setting'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CompanySetting $setting)
    {
        return view('dashboard.settings.edit', compact('setting'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CompanySetting $setting)
    {
        $request->validate([
            'logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'phone' => 'nullable|string|max:20',
            'whatsapp_number' => 'nullable|string|max:30',
            'quote_link' => 'nullable|string|max:255',
            'fax' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'email' => 'nullable|email|max:255',
            'smtp_email' => 'nullable|email|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'notification_email' => 'nullable|email|max:255',
            'instagram' => 'nullable|url',
            'pinterest' => 'nullable|url',
            'facebook' => 'nullable|url',
            'youtube' => 'nullable|url',
            'tiktok' => 'nullable|url',
            'linkedin' => 'nullable|url',
        ]);

        $data = $request->except('logo');

        if (blank($request->input('smtp_password'))) {
            unset($data['smtp_password']);
        }

        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($setting->logo) {
                Storage::disk('public')->delete($setting->logo);
                $this->deletePublicStorageFile($setting->logo);
            }
            $path = $request->file('logo')->store('logos', 'public');
            $this->syncPublicStorageFile($path);
            $data['logo'] = $path;
        }

        $setting->update($data);

        return redirect()->route('settings.index')->with('success', 'Setting updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CompanySetting $setting)
    {
        if ($setting->logo) {
            Storage::disk('public')->delete($setting->logo);
            $this->deletePublicStorageFile($setting->logo);
        }
        $setting->delete();

        return redirect()->route('settings.index')->with('success', 'Setting deleted successfully.');
    }

    protected function syncPublicStorageFile(string $path): void
    {
        $source = storage_path('app/public/'.$path);
        $destination = public_path('storage/'.$path);

        if (File::exists($source)) {
            File::ensureDirectoryExists(dirname($destination));
            File::copy($source, $destination);
        }
    }

    protected function deletePublicStorageFile(string $path): void
    {
        $publicPath = public_path('storage/'.$path);

        if (File::exists($publicPath)) {
            File::delete($publicPath);
        }
    }
}
