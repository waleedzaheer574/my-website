<?php

namespace App\Http\Controllers;

use App\Models\WhyNexa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class WhyNexaController extends Controller
{
    private const MAX_ITEMS = 3;

    public function index()
    {
        $whyNexas = WhyNexa::orderBy('sort_order')->latest()->paginate(10);
        $canCreate = WhyNexa::count() < self::MAX_ITEMS;

        return view('dashboard.why-nexa.index', compact('whyNexas', 'canCreate'));
    }

    public function create()
    {
        if (WhyNexa::count() >= self::MAX_ITEMS) {
            return redirect()->route('why-nexa.index')->withErrors('You can add maximum 3 Why Nexa items.');
        }

        return view('dashboard.why-nexa.create');
    }

    public function store(Request $request)
    {
        if (WhyNexa::count() >= self::MAX_ITEMS) {
            return redirect()->route('why-nexa.index')->withErrors('You can add maximum 3 Why Nexa items.');
        }

        $validated = $this->validateWhyNexa($request);
        $validated['icon'] = $request->hasFile('icon') ? $this->uploadIcon($request->file('icon')) : null;
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        WhyNexa::create($validated);

        return redirect()->route('why-nexa.index')->with('success', 'Why Nexa item added successfully.');
    }

    public function edit(WhyNexa $whyNexa)
    {
        return view('dashboard.why-nexa.edit', compact('whyNexa'));
    }

    public function update(Request $request, WhyNexa $whyNexa)
    {
        $validated = $this->validateWhyNexa($request, false);

        if ($request->hasFile('icon')) {
            $this->deleteIcon($whyNexa->icon);
            $validated['icon'] = $this->uploadIcon($request->file('icon'));
        } else {
            unset($validated['icon']);
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $whyNexa->update($validated);

        return redirect()->route('why-nexa.index')->with('success', 'Why Nexa item updated successfully.');
    }

    public function destroy(WhyNexa $whyNexa)
    {
        $this->deleteIcon($whyNexa->icon);
        $whyNexa->delete();

        return redirect()->route('why-nexa.index')->with('success', 'Why Nexa item deleted successfully.');
    }

    protected function validateWhyNexa(Request $request, bool $iconRequired = false): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_ar' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'icon' => [($iconRequired ? 'required' : 'nullable'), 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    protected function uploadIcon($file): string
    {
        $destination = public_path('uploads/why-nexa');

        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($destination, $fileName);

        return 'uploads/why-nexa/' . $fileName;
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
}
