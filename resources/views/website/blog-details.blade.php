@extends('layouts.website')

@php
  $publishedDate = optional($blog->published_at)->format('d M, Y') ?: $blog->created_at->format('d M, Y');
  $authorName = $blog->author_name ?: 'Multitechwave';
  $authorInitial = \Illuminate\Support\Str::of($authorName)->substr(0, 1)->upper();
  $contentWithBreaks = preg_replace('/<\/(p|h[1-6]|li|blockquote)>/i', '$0'.PHP_EOL.PHP_EOL, (string) $blog->content);
  $contentText = trim(html_entity_decode(strip_tags($contentWithBreaks), ENT_QUOTES, 'UTF-8'));
  $contentParagraphs = collect(preg_split('/\R{2,}/', $contentText))
    ->map(fn ($paragraph) => trim(preg_replace('/\s+/', ' ', $paragraph)))
    ->filter();
  $wordCount = str_word_count(strip_tags($blog->title.' '.$blog->excerpt.' '.$contentText));
  $readingTime = max(1, (int) ceil($wordCount / 200));
  $shareUrl = urlencode(request()->fullUrl());
  $shareTitle = urlencode($blog->title);
@endphp

@section('content')
  <main class="tcw-article-page">
    <section class="tcw-article-header">
      <div class="container tcw-article-container">
        <nav class="tcw-article-breadcrumb" aria-label="Breadcrumb">
          <a href="{{ url('/') }}">Home</a>
          <i class="fas fa-chevron-right"></i>
          <a href="{{ route('website.blog') }}">Blog</a>
          <i class="fas fa-chevron-right"></i>
          <span>{{ \Illuminate\Support\Str::limit($blog->title, 64) }}</span>
        </nav>

        @if($blog->category)
          <span class="tcw-article-category">{{ $blog->category }}</span>
        @endif

        <h1>{{ $blog->title }}</h1>

        <div class="tcw-article-metadata" aria-label="Article details">
          <span><i class="far fa-user"></i> By {{ $authorName }}</span>
          <span><i class="far fa-calendar-alt"></i> {{ $publishedDate }}</span>
          <span><i class="far fa-eye"></i> {{ number_format($blog->views) }} Views</span>
          <span><i class="far fa-clock"></i> {{ $readingTime }} min read</span>
        </div>

        <figure class="tcw-article-cover">
          <img src="{{ asset($blog->featured_image) }}" alt="{{ $blog->title }}" loading="eager" decoding="async" fetchpriority="high">
        </figure>
      </div>
    </section>

    <section class="tcw-article-content">
      <div class="container tcw-article-container">
        <div class="tcw-article-layout">
          <aside class="tcw-article-share" aria-label="Share article">
            <strong>Share</strong>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" aria-label="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank" rel="noopener noreferrer" aria-label="Share on Twitter"><i class="fab fa-twitter"></i></a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" aria-label="Share on LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          </aside>

          <article class="tcw-article-main">
            <div class="tcw-article-body" id="article-overview">
              @if($blog->excerpt)
                <p class="tcw-article-lead">{{ $blog->excerpt }}</p>
              @endif

              @forelse($contentParagraphs as $paragraph)
                <p>{{ $paragraph }}</p>
              @empty
                <p>More article details will be available soon.</p>
              @endforelse
            </div>

            <section class="tcw-article-author" id="article-author">
              @if($blog->author_image)
                <img src="{{ asset($blog->author_image) }}" alt="{{ $authorName }}" width="82" height="82" loading="lazy" decoding="async">
              @else
                <span class="tcw-article-author-avatar">{{ $authorInitial }}</span>
              @endif
              <div>
                <small>About the author</small>
                <h2>{{ $authorName }}</h2>
                <p>{{ $blog->author_bio ?: 'The Multitechwave team writes about growth, design, SEO, and performance-driven digital experiences.' }}</p>
              </div>
              <div class="tcw-article-author-links">
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank" rel="noopener noreferrer" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
              </div>
            </section>
          </article>

          <aside class="tcw-article-sidebar">
            <nav class="tcw-article-toc" aria-label="Table of contents">
              <h2>Table Of Contents</h2>
              <a class="is-active" href="#article-overview">Article Overview</a>
              @if($blog->category)
                <span>{{ $blog->category }}</span>
              @endif
              <a href="#article-author">About The Author</a>
              <a href="#related-articles">Related Articles</a>
            </nav>

            <div class="tcw-article-cta">
              <i class="fas fa-lightbulb"></i>
              <h2>Start Your Digital Journey Today</h2>
              <p>Build and scale your online presence with practical digital solutions.</p>
              <a href="{{ url('/contact') }}">Contact Our Experts</a>
            </div>
          </aside>
        </div>
      </div>
    </section>

    <section class="tcw-article-related" id="related-articles">
      <div class="container tcw-article-container">
        <header class="tcw-article-related-head">
          <span>More Insights</span>
          <h2>Related Articles</h2>
        </header>

        <div class="tcw-article-related-grid" data-load-more-grid data-load-more-step="4">
          @forelse($relatedBlogs as $relatedBlog)
            <a href="{{ route('website.blog-details.show', $relatedBlog->slug) }}" class="tcw-article-card tcw-load-more-item {{ $loop->index >= 4 ? 'is-hidden' : '' }}" data-load-more-item>
              <img src="{{ asset($relatedBlog->featured_image) }}" alt="{{ $relatedBlog->title }}" loading="lazy" decoding="async">
              <time>{{ optional($relatedBlog->published_at)->format('d M, Y') ?: $relatedBlog->created_at->format('d M, Y') }}</time>
              <h3>{{ $relatedBlog->title }}</h3>
              <span>Read More <i class="fas fa-arrow-right"></i></span>
            </a>
          @empty
            <div class="tcw-article-empty">No related articles found.</div>
          @endforelse
        </div>

        @if($relatedBlogs->count() > 4)
          <div class="tcw-load-more-wrap">
            <button type="button" class="tcw-load-more-btn" data-load-more-btn>
              <i class="fas fa-sync-alt"></i> Load More
            </button>
          </div>
        @endif
      </div>
    </section>
  </main>
@endsection
