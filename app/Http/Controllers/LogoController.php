<?php

namespace App\Http\Controllers;

use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    public function index()
    {
        $logos = Logo::latest()->paginate(10);
        return view('dashboard.logos.index', compact('logos'));
    }

    public function create()
    {
        return view('dashboard.logos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'logo' => 'required|file|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        $validated['logo'] = $request->file('logo')->store('logos', 'public');
        $this->syncPublicStorageFile($validated['logo']);

        Logo::create($validated);

        return redirect()->route('logos.index')->with('success', 'Logo added successfully.');
    }

    public function show(Logo $logo)
    {
        return redirect()->route('logos.index');
    }

    public function edit(Logo $logo)
    {
        return view('dashboard.logos.edit', compact('logo'));
    }

    public function update(Request $request, Logo $logo)
    {
        $validated = $request->validate([
            'logo' => 'nullable|file|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($logo->logo) {
                Storage::disk('public')->delete($logo->logo);
                $this->deletePublicStorageFile($logo->logo);
            }

            $validated['logo'] = $request->file('logo')->store('logos', 'public');
            $this->syncPublicStorageFile($validated['logo']);
            $logo->update($validated);
        }

        return redirect()->route('logos.index')->with('success', 'Logo updated successfully.');
    }

    public function destroy(Logo $logo)
    {
        if ($logo->logo) {
            Storage::disk('public')->delete($logo->logo);
            $this->deletePublicStorageFile($logo->logo);
        }

        $logo->delete();

        return redirect()->route('logos.index')->with('success', 'Logo deleted successfully.');
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
