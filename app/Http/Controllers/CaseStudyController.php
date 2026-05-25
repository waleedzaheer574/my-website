<?php

namespace App\Http\Controllers;

use App\Models\CaseStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CaseStudyController extends Controller
{
    public function index()
    {
        $caseStudies = CaseStudy::orderBy('sort_order')->latest()->paginate(10);

        return view('dashboard.case-studies.index', compact('caseStudies'));
    }

    public function create()
    {
        return view('dashboard.case-studies.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateCaseStudy($request);
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        $validated['image'] = $request->hasFile('image') ? $this->uploadImage($request->file('image')) : null;
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        CaseStudy::create($validated);

        return redirect()->route('case-studies.index')->with('success', 'Case study added successfully.');
    }

    public function edit(CaseStudy $caseStudy)
    {
        return view('dashboard.case-studies.edit', compact('caseStudy'));
    }

    public function update(Request $request, CaseStudy $caseStudy)
    {
        $validated = $this->validateCaseStudy($request, false);
        $validated['slug'] = $this->generateUniqueSlug($validated['title'], $caseStudy->id);

        if ($request->hasFile('image')) {
            $this->deleteImage($caseStudy->image);
            $validated['image'] = $this->uploadImage($request->file('image'));
        } else {
            unset($validated['image']);
        }

        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $caseStudy->update($validated);

        return redirect()->route('case-studies.index')->with('success', 'Case study updated successfully.');
    }

    public function destroy(CaseStudy $caseStudy)
    {
        $this->deleteImage($caseStudy->image);
        $caseStudy->delete();

        return redirect()->route('case-studies.index')->with('success', 'Case study deleted successfully.');
    }

    public function webIndex()
    {
        $caseStudies = CaseStudy::where('is_active', true)
            ->orderBy('sort_order')
            ->latest()
            ->paginate(6);

        return view('website.case-studies', compact('caseStudies'));
    }

    protected function validateCaseStudy(Request $request, bool $imageRequired = false): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'title_ar' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'category_ar' => ['nullable', 'string', 'max:255'],
            'image' => [($imageRequired ? 'required' : 'nullable'), 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:1536'],
            'summary' => ['nullable', 'string'],
            'summary_ar' => ['nullable', 'string'],
            'result' => ['nullable', 'string', 'max:255'],
            'result_ar' => ['nullable', 'string', 'max:255'],
            'cta_url' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    protected function uploadImage($file): string
    {
        $destination = public_path('uploads/case-studies');

        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($destination, $fileName);

        return 'uploads/case-studies/' . $fileName;
    }

    protected function deleteImage(?string $path): void
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
        $slug = Str::slug($title) ?: 'case-study';
        $originalSlug = $slug;
        $counter = 1;

        while (
            CaseStudy::when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
