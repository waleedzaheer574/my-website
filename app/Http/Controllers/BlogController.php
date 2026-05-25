<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->paginate(10);

        return view('dashboard.blogs.index', compact('blogs'));
    }

    public function create()
    {
        return view('dashboard.blogs.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateBlog($request);
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        $validated = $this->prepareBlogData($request, $validated);

        Blog::create($validated);

        return redirect()->route('blogs.index')->with('success', 'Blog added successfully.');
    }

    public function storePublic(Request $request)
    {
        $validated = $this->validateBlog($request, null, true);
        $validated['slug'] = $this->generateUniqueSlug($validated['title']);
        $validated['is_active'] = true;
        $validated['published_at'] = $validated['published_at'] ?? now();
        $validated = $this->prepareBlogData($request, $validated);

        Blog::create($validated);

        return redirect()->route('website.blog', ['#' => 'share-blog'])->with('success', 'Your blog has been published successfully.');
    }

    public function show(Blog $blog)
    {
        return view('dashboard.blogs.show', compact('blog'));
    }

    public function edit(Blog $blog)
    {
        return view('dashboard.blogs.edit', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $this->validateBlog($request, $blog->id);
        $validated['slug'] = $this->generateUniqueSlug($validated['title'], $blog->id);
        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);
        $validated['views'] = $validated['views'] ?? $blog->views;

        if ($request->hasFile('featured_image')) {
            $this->deleteImage($blog->featured_image);
            $validated['featured_image'] = $this->uploadImage($request->file('featured_image'));
        } else {
            unset($validated['featured_image']);
        }

        if ($request->hasFile('author_image')) {
            $this->deleteImage($blog->author_image);
            $validated['author_image'] = $this->uploadImage($request->file('author_image'));
        } else {
            unset($validated['author_image']);
        }

        $blog->update($validated);

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        $this->deleteImage($blog->featured_image);
        $this->deleteImage($blog->author_image);
        $blog->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }

    public function webIndex()
    {
        $blogs = Blog::where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->latest('published_at')
            ->latest()
            ->get();

        return view('website.blog', compact('blogs'));
    }

    public function webShow(?Blog $blog = null)
    {
        if ($blog) {
            $isPublished = $blog->is_active && (! $blog->published_at || $blog->published_at->lte(now()));

            abort_unless($isPublished, 404);

            $blog->increment('views');
            $blog->refresh();
        } else {
            $blog = Blog::where('is_active', true)
                ->where(function ($query) {
                    $query->whereNull('published_at')
                        ->orWhere('published_at', '<=', now());
                })
                ->latest('published_at')
                ->latest()
                ->firstOrFail();

            if ($blog->slug) {
                return redirect()->route('website.blog-details.show', $blog->slug, 301);
            }
        }

        $relatedBlogs = Blog::where('id', '!=', $blog->id)
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('published_at')
                    ->orWhere('published_at', '<=', now());
            })
            ->latest('published_at')
            ->latest()
            ->get();

        return view('website.blog-details', compact('blog', 'relatedBlogs'));
    }

    protected function validateBlog(Request $request, ?int $id = null, bool $isPublic = false): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'author_image' => 'nullable|image|mimes:jpg,jpeg,png,webp,svg|max:1024',
            'featured_image' => ($id ? 'nullable' : 'required').'|image|mimes:jpg,jpeg,png,webp,svg|max:2048',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'author_bio' => 'nullable|string',
            'views' => $isPublic ? 'nullable' : 'nullable|integer|min:0',
            'is_active' => $isPublic ? 'nullable' : 'nullable|boolean',
            'published_at' => 'nullable|date',
        ]);
    }

    protected function prepareBlogData(Request $request, array $validated): array
    {
        $validated['featured_image'] = $request->hasFile('featured_image')
            ? $this->uploadImage($request->file('featured_image'))
            : ($validated['featured_image'] ?? null);
        $validated['author_image'] = $request->hasFile('author_image')
            ? $this->uploadImage($request->file('author_image'))
            : ($validated['author_image'] ?? null);
        $validated['is_active'] = (bool) ($validated['is_active'] ?? true);
        $validated['views'] = (int) ($validated['views'] ?? 0);

        return $validated;
    }

    protected function uploadImage($file): string
    {
        $destination = public_path('uploads/blogs');

        if (! File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $fileName = time().'_'.uniqid().'.'.$file->getClientOriginalExtension();
        $file->move($destination, $fileName);

        return 'uploads/blogs/'.$fileName;
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
        $slug = Str::slug($title ?: 'blog');
        $originalSlug = $slug ?: 'blog';
        $counter = 1;

        while (
            Blog::when($ignoreId, fn ($query) => $query->where('id', '!=', $ignoreId))
                ->where('slug', $slug)
                ->exists()
        ) {
            $slug = $originalSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
