@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Blog Preview</h2>
@endsection

@section('content')
    <div class="card">
        <div class="admin-u-017">
            <div>
                <img class="admin-u-074" src="{{ asset($blog->featured_image) }}" alt="{{ $blog->title }}">
            </div>

            <div>
                <h3 class="admin-u-018">{{ $blog->title }}</h3>
                <p><strong>Author:</strong> {{ $blog->author_name }}</p>
                <p><strong>Category:</strong> {{ $blog->category ?: 'N/A' }}</p>
                <p><strong>Status:</strong> {{ $blog->is_active ? 'Active' : 'Inactive' }}</p>
                <p><strong>Published:</strong> {{ $blog->published_at ? $blog->published_at->format('d M, Y h:i A') : 'Draft' }}</p>
                <p><strong>Views:</strong> {{ $blog->views }}</p>
                @if($blog->excerpt)
                    <p><strong>Excerpt:</strong> {{ $blog->excerpt }}</p>
                @endif
                @if($blog->author_bio)
                    <p><strong>Author Bio:</strong> {{ $blog->author_bio }}</p>
                @endif
            </div>

            <div>
                <h4 class="admin-u-019">Content</h4>
                <div class="admin-u-020">{{ $blog->content }}</div>
            </div>

            <div class="admin-u-009">
                <a href="{{ route('blogs.edit', $blog->slug) }}" class="btn btn-primary">Edit Blog</a>
                <a href="{{ route('blogs.index') }}" class="btn admin-u-005">Back</a>
            </div>
        </div>
    </div>
@endsection
