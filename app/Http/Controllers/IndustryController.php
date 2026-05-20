<?php

namespace App\Http\Controllers;

use App\Models\Industry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class IndustryController extends Controller
{
    public function index()
    {
        $industries = Industry::orderBy('sort_order')->latest()->paginate(10);

        return view('dashboard.industries.index', compact('industries'));
    }

    public function create()
    {
        return view('dashboard.industries.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateIndustry($request);
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        $validated['icon'] = $request->hasFile('icon') ? $this->uploadIcon($request->file('icon')) : null;
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Industry::create($validated);

        return redirect()->route('industries.index')->with('success', 'Industry added successfully.');
    }

    public function edit(Industry $industry)
    {
        return view('dashboard.industries.edit', compact('industry'));
    }

    public function update(Request $request, Industry $industry)
    {
        $validated = $this->validateIndustry($request, false);
        $validated['slug'] = $this->generateUniqueSlug($validated['title'], $industry->id);

        if ($request->hasFile('icon')) {
            $this->deleteIcon($industry->icon);
            $validated['icon'] = $this->uploadIcon($request->file('icon'));
        } else {
            unset($validated['icon']);
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $industry->update($validated);

        return redirect()->route('industries.index')->with('success', 'Industry updated successfully.');
    }

    public function destroy(Industry $industry)
    {
        $this->deleteIcon($industry->icon);
        $industry->delete();

        return redirect()->route('industries.index')->with('success', 'Industry deleted successfully.');
    }

    public function webIndex()
    {
        $industries = Industry::where('is_active', true)
            ->orderBy('sort_order')
            ->latest()
            ->get();

        return view('website.industries', compact('industries'));
    }

    protected function validateIndustry(Request $request, bool $iconRequired = false): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'result' => ['nullable', 'string', 'max:255'],
            'cta_url' => ['nullable', 'string', 'max:255'],
            'icon' => [($iconRequired ? 'required' : 'nullable'), 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:512'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    protected function uploadIcon($file): string
    {
        $destination = public_path('uploads/industries');

        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($destination, $fileName);

        return 'uploads/industries/' . $fileName;
    }

    protected function deleteIcon(?string $path): void
    {
        if (!$path) {
            return;
        }

        $fullPath = public_path($path);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }

    protected function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title) ?: 'industry';
        $originalSlug = $slug;
        $counter = 1;

        while (
            Industry::when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
