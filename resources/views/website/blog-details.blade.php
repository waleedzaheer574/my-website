@extends('layouts.website')

@php
  $publishedDate = $blog->published_at?->locale(app()->getLocale())->translatedFormat('d M, Y') ?: $blog->created_at->locale(app()->getLocale())->translatedFormat('d M, Y');
  $authorName = $blog->author_name ?: 'Multitechwave';
  $authorInitial = \Illuminate\Support\Str::of($authorName)->substr(0, 1)->upper();
  $contentWithBreaks = preg_replace('/<\/(p|h[1-6]|li|blockquote)>/i', '$0'.PHP_EOL.PHP_EOL, (string) $blog->localized('content'));
  $contentText = trim(html_entity_decode(strip_tags($contentWithBreaks), ENT_QUOTES, 'UTF-8'));
  $contentParagraphs = collect(preg_split('/\R{2,}/', $contentText))
    ->map(fn ($paragraph) => trim(preg_replace('/\s+/', ' ', $paragraph)))
    ->filter();
  $wordCount = str_word_count(strip_tags($blog->localized('title').' '.$blog->localized('excerpt').' '.$contentText));
  $readingTime = max(1, (int) ceil($wordCount / 200));
  $shareUrl = urlencode(request()->fullUrl());
  $shareTitle = urlencode($blog->localized('title'));
@endphp

@section('content')
  <main class="tcw-article-page">
    <section class="tcw-article-header">
      <div class="container tcw-article-container">
        <nav class="tcw-article-breadcrumb" aria-label="Breadcrumb">
          <a href="{{ url('/') }}">{{ __('website.nav.home') }}</a>
          <i class="fas fa-chevron-right"></i>
          <a href="{{ route('website.blog') }}">{{ __('website.nav.blog') }}</a>
          <i class="fas fa-chevron-right"></i>
          <span>{{ \Illuminate\Support\Str::limit($blog->localized('title'), 64) }}</span>
        </nav>

        @if($blog->localized('category'))
          <span class="tcw-article-category">{{ $blog->localized('category') }}</span>
        @endif

        <h1>{{ $blog->localized('title') }}</h1>

        <div class="tcw-article-metadata" aria-label="Article details">
          <span><i class="far fa-user"></i> {{ __('website.article.by') }} {{ $authorName }}</span>
          <span><i class="far fa-calendar-alt"></i> {{ $publishedDate }}</span>
          <span><i class="far fa-eye"></i> {{ number_format($blog->views) }} {{ __('website.article.views') }}</span>
          <span><i class="far fa-clock"></i> {{ $readingTime }} {{ __('website.article.read_time') }}</span>
        </div>

        <figure class="tcw-article-cover">
          <img src="{{ asset($blog->featured_image) }}" alt="{{ $blog->localized('title') }}" loading="eager" decoding="async" fetchpriority="high">
        </figure>
      </div>
    </section>

    <section class="tcw-article-content">
      <div class="container tcw-article-container">
        <div class="tcw-article-layout">
          <aside class="tcw-article-share" aria-label="Share article">
            <strong>{{ __('website.article.share') }}</strong>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" aria-label="Share on Facebook"><i class="fab fa-facebook-f"></i></a>
            <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank" rel="noopener noreferrer" aria-label="Share on Twitter"><i class="fab fa-twitter"></i></a>
            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" aria-label="Share on LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          </aside>

          <article class="tcw-article-main">
            <div class="tcw-article-body" id="article-overview">
              @if($blog->localized('excerpt'))
                <p class="tcw-article-lead">{{ $blog->localized('excerpt') }}</p>
              @endif

              @forelse($contentParagraphs as $paragraph)
                <p>{{ $paragraph }}</p>
              @empty
                <p>{{ __('website.article.empty_body') }}</p>
              @endforelse
            </div>

            <section class="tcw-article-author" id="article-author">
              @if($blog->author_image)
                <img src="{{ asset($blog->author_image) }}" alt="{{ $authorName }}" width="82" height="82" loading="lazy" decoding="async">
              @else
                <span class="tcw-article-author-avatar">{{ $authorInitial }}</span>
              @endif
              <div>
                <small>{{ __('website.article.author') }}</small>
                <h2>{{ $authorName }}</h2>
                <p>{{ $blog->localized('author_bio') ?: __('website.blog.author_fallback') }}</p>
              </div>
              <div class="tcw-article-author-links">
                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                <a href="https://twitter.com/intent/tweet?url={{ $shareUrl }}&text={{ $shareTitle }}" target="_blank" rel="noopener noreferrer" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
              </div>
            </section>
          </article>

          <aside class="tcw-article-sidebar">
            <nav class="tcw-article-toc" aria-label="Table of contents">
              <h2>{{ __('website.article.toc') }}</h2>
              <a class="is-active" href="#article-overview">{{ __('website.article.overview') }}</a>
              @if($blog->localized('category'))
                <span>{{ $blog->localized('category') }}</span>
              @endif
              <a href="#article-author">{{ __('website.article.author') }}</a>
              <a href="#related-articles">{{ __('website.article.related') }}</a>
            </nav>

            <div class="tcw-article-cta">
              <i class="fas fa-lightbulb"></i>
              <h2>{{ __('website.article.cta_title') }}</h2>
              <p>{{ __('website.article.cta_text') }}</p>
              <a href="{{ url('/contact') }}">{{ __('website.article.cta_button') }}</a>
            </div>
          </aside>
        </div>
      </div>
    </section>

    <section class="tcw-article-related" id="related-articles">
      <div class="container tcw-article-container">
        <header class="tcw-article-related-head">
          <span>{{ __('website.article.insights') }}</span>
          <h2>{{ __('website.article.related') }}</h2>
        </header>

        <div class="tcw-article-related-grid" data-load-more-grid data-load-more-step="4">
          @forelse($relatedBlogs as $relatedBlog)
            <a href="{{ route('website.blog-details.show', $relatedBlog->slug) }}" class="tcw-article-card tcw-load-more-item {{ $loop->index >= 4 ? 'is-hidden' : '' }}" data-load-more-item>
              <img src="{{ asset($relatedBlog->featured_image) }}" alt="{{ $relatedBlog->localized('title') }}" loading="lazy" decoding="async">
              <time>{{ $relatedBlog->published_at?->locale(app()->getLocale())->translatedFormat('d M, Y') ?: $relatedBlog->created_at->locale(app()->getLocale())->translatedFormat('d M, Y') }}</time>
              <h3>{{ $relatedBlog->localized('title') }}</h3>
              <span>{{ __('website.article.read_more') }} <i class="fas fa-arrow-right"></i></span>
            </a>
          @empty
            <div class="tcw-article-empty">{{ __('website.article.no_related') }}</div>
          @endforelse
        </div>

        @if($relatedBlogs->count() > 4)
          <div class="tcw-load-more-wrap">
            <button type="button" class="tcw-load-more-btn" data-load-more-btn>
              <i class="fas fa-sync-alt"></i> {{ __('website.common.load_more') }}
            </button>
          </div>
        @endif
      </div>
    </section>
  </main>
@endsection
