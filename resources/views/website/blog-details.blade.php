@extends('layouts.website')

@php
  $publishedDate = optional($blog->published_at)->format('d M, Y') ?: $blog->created_at->format('d M, Y');
  $authorInitial = \Illuminate\Support\Str::of($blog->author_name ?: 'M')->substr(0, 1)->upper();
@endphp

@section('content')
  <main class="tcw-blog-detail-page">
    <section class="tcw-blog-detail-hero">
      <div class="container">
        <div class="tcw-blog-detail-shell wow fadeInUp" data-wow-duration="0.9s" data-wow-delay="0.1s">
          <nav class="tcw-detail-breadcrumb wow fadeIn" data-wow-duration="0.8s" data-wow-delay="0.2s" aria-label="Breadcrumb">
            <a href="{{ url('/') }}">Home</a>
            <i class="fas fa-chevron-right"></i>
            <a href="{{ route('website.blog') }}">Blog</a>
            <i class="fas fa-chevron-right"></i>
            <span>{{ $blog->title }}</span>
          </nav>

          <div class="tcw-blog-detail-meta wow fadeInUp" data-wow-duration="0.8s" data-wow-delay="0.3s">
            <span>By {{ $blog->author_name ?: 'Multitechwave' }}</span>
            @if($blog->category)
              <span>{{ $blog->category }}</span>
            @endif
            <span>{{ $publishedDate }}</span>
            <span>{{ $blog->views }} {{ \Illuminate\Support\Str::plural('view', $blog->views) }}</span>
          </div>

          <h1 class="wow fadeInUp" data-wow-duration="0.9s" data-wow-delay="0.4s">{{ $blog->title }}</h1>

          @if($blog->excerpt)
            <p class="tcw-blog-detail-excerpt wow fadeInUp" data-wow-duration="0.9s" data-wow-delay="0.5s">{{ $blog->excerpt }}</p>
          @endif

          <div class="tcw-blog-detail-image cs-lightgallery wow fadeIn" data-wow-duration="1s" data-wow-delay="0.6s">
            <a href="{{ asset($blog->featured_image) }}" class="cs-lightbox-item" aria-label="Open full blog image">
              <img src="{{ asset($blog->featured_image) }}" alt="{{ $blog->title }}" loading="eager" decoding="async" fetchpriority="high">
              <span class="tcw-blog-image-zoom"><i class="fas fa-search-plus"></i></span>
            </a>
          </div>
        </div>
      </div>
    </section>

    <section class="tcw-blog-detail-content">
      <div class="container">
        <div class="tcw-blog-detail-grid">
          <aside class="tcw-blog-share wow fadeInLeft" data-wow-duration="0.9s" data-wow-delay="0.1s" aria-label="Share article">
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}" target="_blank" rel="noopener noreferrer" aria-label="Share on Facebook">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($blog->title) }}" target="_blank" rel="noopener noreferrer" aria-label="Share on Twitter">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(request()->fullUrl()) }}" target="_blank" rel="noopener noreferrer" aria-label="Share on LinkedIn">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </aside>

          <article class="tcw-blog-article">
            <div class="tcw-blog-body wow fadeInUp" data-wow-duration="0.9s" data-wow-delay="0.15s">{!! nl2br(e($blog->content)) !!}</div>

            <div class="tcw-blog-author-card wow fadeInUp" data-wow-duration="0.9s" data-wow-delay="0.25s">
              @if($blog->author_image)
                <img src="{{ asset($blog->author_image) }}" alt="{{ $blog->author_name }}" width="96" height="96" loading="lazy" decoding="async">
              @else
                <div class="tcw-blog-author-avatar">{{ $authorInitial }}</div>
              @endif
              <div>
                <span>About author</span>
                <h2>{{ $blog->author_name ?: 'Multitechwave' }}</h2>
                <p>{{ $blog->author_bio ?: 'The Multitechwave team writes about growth, design, SEO, and performance marketing.' }}</p>
              </div>
            </div>
          </article>
        </div>
      </div>
    </section>

    <section class="tcw-blog-related-section">
      <div class="container">
        <div class="tcw-blog-related-head wow fadeInUp" data-wow-duration="0.9s" data-wow-delay="0.1s">
          <span>More insights</span>
          <h2>Related Articles</h2>
        </div>

        <div class="tcw-blog-related-grid" data-load-more-grid data-load-more-step="6">
          @forelse($relatedBlogs as $relatedBlog)
            <a href="{{ route('website.blog-details.show', $relatedBlog->slug) }}" class="tcw-blog-related-card tcw-load-more-item {{ $loop->index >= 6 ? 'is-hidden' : '' }} wow fadeInUp" data-load-more-item data-wow-duration="0.9s" data-wow-delay="{{ number_format(0.15 + ($loop->index * 0.08), 2) }}s">
              <img src="{{ asset($relatedBlog->featured_image) }}" alt="{{ $relatedBlog->title }}" loading="lazy" decoding="async">
              <span class="tcw-blog-related-meta">
                <span>{{ $relatedBlog->category ?: 'Blog' }}</span>
                <span>{{ optional($relatedBlog->published_at)->format('d M, Y') ?: $relatedBlog->created_at->format('d M, Y') }}</span>
              </span>
              <h3>{{ $relatedBlog->title }}</h3>
              @if($relatedBlog->excerpt)
                <p>{{ \Illuminate\Support\Str::limit($relatedBlog->excerpt, 110) }}</p>
              @endif
            </a>
          @empty
            <div class="tcw-blog-related-empty">No related articles found.</div>
          @endforelse
        </div>

        @if($relatedBlogs->count() > 6)
          <div class="tcw-load-more-wrap wow fadeInUp" data-wow-duration="0.9s" data-wow-delay="0.1s">
            <button type="button" class="tcw-load-more-btn" data-load-more-btn>
              <i class="fas fa-sync-alt"></i> Load More
            </button>
          </div>
        @endif
      </div>
    </section>
  </main>
@endsection
