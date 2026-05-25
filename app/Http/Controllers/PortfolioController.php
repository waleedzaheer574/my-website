<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PortfolioController extends Controller
{
    public function index()
    {
        $portfolios = Portfolio::orderBy('sort_order')->latest()->paginate(10);

        return view('dashboard.portfolios.index', compact('portfolios'));
    }

    public function create()
    {
        return view('dashboard.portfolios.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatePortfolio($request);
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        $validated['image'] = $this->uploadImage($request->file('image'));

        foreach (['secondary_image', 'detail_image'] as $field) {
            if ($request->hasFile($field)) {
                $validated[$field] = $this->uploadImage($request->file($field));
            }
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        Portfolio::create($validated);

        return redirect()->route('portfolios.index')->with('success', 'Portfolio added successfully.');
    }

    public function edit(Portfolio $portfolio)
    {
        return view('dashboard.portfolios.edit', compact('portfolio'));
    }

    public function update(Request $request, Portfolio $portfolio)
    {
        $validated = $this->validatePortfolio($request, false);
        $validated['slug'] = $this->generateUniqueSlug($validated['title'], $portfolio->id);

        if ($request->hasFile('image')) {
            $this->deleteImage($portfolio->image);
            $validated['image'] = $this->uploadImage($request->file('image'));
        } else {
            unset($validated['image']);
        }

        foreach (['secondary_image', 'detail_image'] as $field) {
            if ($request->hasFile($field)) {
                $this->deleteImage($portfolio->{$field});
                $validated[$field] = $this->uploadImage($request->file($field));
            } else {
                unset($validated[$field]);
            }
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $portfolio->update($validated);

        return redirect()->route('portfolios.index')->with('success', 'Portfolio updated successfully.');
    }

    public function destroy(Portfolio $portfolio)
    {
        $this->deleteImage($portfolio->image);
        $this->deleteImage($portfolio->secondary_image);
        $this->deleteImage($portfolio->detail_image);
        $portfolio->delete();

        return redirect()->route('portfolios.index')->with('success', 'Portfolio deleted successfully.');
    }

    public function webIndex()
    {
        $portfolios = Portfolio::where('is_active', true)
            ->orderBy('sort_order')
            ->latest()
            ->get();

        return view('website.portfolio', compact('portfolios'));
    }

    public function webShow(?Portfolio $portfolio = null)
    {
        if (! $portfolio) {
            $portfolio = Portfolio::where('is_active', true)
                ->orderBy('sort_order')
                ->latest()
                ->firstOrFail();

            if ($portfolio->slug) {
                return redirect()->route('website.portfolio-details.show', $portfolio->slug, 301);
            }
        }

        abort_unless($portfolio->is_active, 404);

        $relatedPortfolios = Portfolio::where('is_active', true)
            ->where('id', '!=', $portfolio->id)
            ->orderBy('sort_order')
            ->latest()
            ->take(2)
            ->get();

        return view('website.portfolio-details', compact('portfolio', 'relatedPortfolios'));
    }

    protected function validatePortfolio(Request $request, bool $imageRequired = true): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'client' => ['nullable', 'string', 'max:255'],
            'tags' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'demo_url' => ['nullable', 'url', 'max:255'],
            'image' => [($imageRequired ? 'required' : 'nullable'), 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'secondary_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:1536'],
            'detail_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:1536'],
            'short_description' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
    }

    protected function uploadImage($file): string
    {
        $destination = public_path('uploads/portfolios');

        if (! File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move($destination, $fileName);

        return 'uploads/portfolios/'.$fileName;
    }

    protected function deleteImage(?string $path): void
    {
        if (! $path) {
            return;
        }

        $fullPath = public_path($path);

        if (File::exists($fullPath)) {
            File::delete($fullPath);
        }
    }

    protected function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title) ?: 'portfolio';
        $originalSlug = $slug;
        $counter = 1;

        while (
            Portfolio::when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $originalSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
