@extends('layouts.website')

@section('title', $portfolio->localized('title'))
@section('hide_global_faqs', '1')

@php
  $description = $portfolio->localized('description') ?: $portfolio->localized('short_description') ?: __('website.portfolio_detail.fallback_description');
  $gallery = collect([$portfolio->image, $portfolio->secondary_image, $portfolio->detail_image])->filter()->unique()->values();
  $tags = collect(explode(',', (string) $portfolio->localized('tags')))->map(fn ($tag) => trim($tag))->filter()->values();
  $techItems = $tags->isNotEmpty() ? $tags : collect(array_filter([$portfolio->localized('category'), 'UI/UX', 'Development', 'Responsive Design', 'Performance']));
  $rawDemoUrl = trim((string) $portfolio->demo_url);
  $demoUrl = $rawDemoUrl !== '' ? $rawDemoUrl : __('website.portfolio_detail.request');
  $demoHref = $rawDemoUrl !== ''
    ? (\Illuminate\Support\Str::startsWith($rawDemoUrl, ['http://', 'https://']) ? $rawDemoUrl : 'https://' . $rawDemoUrl)
    : null;
@endphp

@section('content')
  <main class="tcw-detail-modern tcw-portfolio-modern">
    <section class="tcw-detail-hero">
      <div class="container">
        <nav class="tcw-detail-breadcrumb" aria-label="Breadcrumb">
          <a href="{{ url('/') }}">{{ __('website.nav.home') }}</a>
          <i class="fas fa-chevron-right"></i>
          <a href="{{ route('website.portfolio') }}">{{ __('website.nav.portfolio') }}</a>
          <i class="fas fa-chevron-right"></i>
          <span>{{ $portfolio->localized('title') }}</span>
        </nav>

        <div class="tcw-detail-hero-grid">
          <div class="tcw-detail-hero-copy">
            <span class="tcw-detail-eyebrow">{{ __('website.portfolio_detail.featured') }}</span>
            <h1>{{ $portfolio->localized('title') }} <span>{{ $portfolio->localized('category') ?: __('website.portfolio_detail.project') }}</span></h1>
            <p>{{ $portfolio->localized('short_description') ?: \Illuminate\Support\Str::limit(strip_tags($description), 190) }}</p>
          </div>

          <div class="tcw-detail-hero-media tcw-portfolio-device cs-lightgallery">
            <a href="{{ asset($portfolio->image) }}" class="tcw-service-image-link cs-lightbox-item" aria-label="Open full portfolio image">
              <img src="{{ asset($portfolio->image) }}" alt="{{ $portfolio->localized('title') }}" width="720" height="540" loading="eager" decoding="async" fetchpriority="high">
              <span class="tcw-blog-image-zoom"><i class="fas fa-search-plus"></i></span>
            </a>
          </div>

          <div class="tcw-detail-actions">
            <a href="{{ $demoHref ?: url('/contact') }}" class="tcw-detail-btn tcw-detail-btn-primary" @if($demoHref) target="_blank" rel="noopener" @endif>
              {{ $portfolio->demo_url ? __('website.portfolio_detail.launch') : __('website.portfolio_detail.similar') }} <i class="fas fa-arrow-right"></i>
            </a>
            <a href="{{ route('website.portfolio') }}" class="tcw-detail-btn tcw-detail-btn-outline">{{ __('website.service_detail.portfolio') }} <i class="far fa-eye"></i></a>
          </div>
        </div>
      </div>
    </section>

    <section class="tcw-detail-section">
      <div class="container">
        <div class="tcw-detail-heading text-center">
          <span class="tcw-detail-eyebrow">{{ __('website.portfolio_detail.process') }}</span>
          <h2>{{ __('website.portfolio_detail.how') }} <span>{{ __('website.portfolio_detail.work') }}</span></h2>
        </div>
        <div class="tcw-process-grid">
          @foreach(__('website.portfolio_detail.steps') as $step)
            <article class="tcw-process-card">
              <div class="tcw-process-icon"><i class="fas {{ ['fa-lightbulb', 'fa-pencil-ruler', 'fa-rocket'][$loop->index] }}"></i></div>
              <span>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</span>
              <h3>{{ $step['title'] }}</h3>
              <p>{{ $step['text'] }}</p>
            </article>
          @endforeach
        </div>
      </div>
    </section>

    <section class="tcw-detail-section tcw-about-detail-section">
      <div class="container">
        <div class="tcw-about-detail-grid">
          <div>
            <div class="tcw-detail-heading">
              <span class="tcw-detail-eyebrow">{{ __('website.portfolio_detail.about') }}</span>
              <h2>{{ __('website.portfolio_detail.overview') }}</h2>
            </div>
            <div class="tcw-detail-richtext">{!! nl2br(e($description)) !!}</div>
            <div class="tcw-feature-mini-grid tcw-portfolio-facts">
              <div class="tcw-feature-mini"><i class="fas fa-user-tie"></i><div><h4>{{ __('website.portfolio_detail.client') }}</h4><p>{{ $portfolio->client ?: 'N/A' }}</p></div></div>
              <div class="tcw-feature-mini"><i class="fas fa-layer-group"></i><div><h4>{{ __('website.portfolio_detail.category') }}</h4><p>{{ $portfolio->localized('category') ?: 'N/A' }}</p></div></div>
              <div class="tcw-feature-mini"><i class="fas fa-clock"></i><div><h4>{{ __('website.portfolio_detail.duration') }}</h4><p>{{ $portfolio->localized('duration') ?: 'N/A' }}</p></div></div>
              <div class="tcw-feature-mini"><i class="fas fa-layer-group"></i><div><h4>{{ __('website.portfolio_detail.services') }}</h4><p>{{ $portfolio->localized('tags') ?: ($portfolio->localized('category') ?: 'N/A') }}</p></div></div>
              <div class="tcw-feature-mini tcw-portfolio-demo-fact"><i class="fas fa-link"></i><div><h4>{{ __('website.portfolio_detail.demo') }}</h4><p>@if($demoHref)<a href="{{ $demoHref }}" target="_blank" rel="noopener noreferrer">{{ $demoUrl }}</a>@else{{ $demoUrl }}@endif</p></div></div>
            </div>
          </div>

          <div>
            <div class="tcw-detail-video tcw-portfolio-preview cs-lightgallery">
              @php($portfolioPreviewImage = $portfolio->secondary_image ?: $portfolio->image)
              <a href="{{ asset($portfolioPreviewImage) }}" class="tcw-service-image-link cs-lightbox-item" aria-label="Open full portfolio preview image">
                <img src="{{ asset($portfolioPreviewImage) }}" alt="{{ $portfolio->localized('title') }} preview" width="720" height="405" loading="lazy" decoding="async">
                <span class="tcw-blog-image-zoom"><i class="fas fa-search-plus"></i></span>
              </a>
            </div>
            <div class="tcw-detail-info-card">
              <div><i class="fas fa-user-tie"></i><strong>{{ __('website.portfolio_detail.client') }}</strong><span>{{ $portfolio->client ?: 'N/A' }}</span></div>
              <div><i class="fas fa-layer-group"></i><strong>{{ __('website.portfolio_detail.category') }}</strong><span>{{ $portfolio->localized('category') ?: 'N/A' }}</span></div>
              <div><i class="fas fa-clock"></i><strong>{{ __('website.portfolio_detail.duration') }}</strong><span>{{ $portfolio->localized('duration') ?: 'N/A' }}</span></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="tcw-detail-section pt-0">
      <div class="container">
        <div class="tcw-detail-heading text-center">
          <h2><span>{{ __('website.portfolio_detail.gallery') }}</span></h2>
        </div>
        <div class="tcw-project-gallery cs-lightgallery">
          @foreach($gallery as $image)
            <div>
              <a href="{{ asset($image) }}" class="tcw-service-image-link cs-lightbox-item" aria-label="Open portfolio gallery image {{ $loop->iteration }}">
                <img src="{{ asset($image) }}" alt="{{ $portfolio->localized('title') }} image {{ $loop->iteration }}" width="720" height="480" loading="lazy" decoding="async">
                <span class="tcw-blog-image-zoom"><i class="fas fa-search-plus"></i></span>
              </a>
            </div>
          @endforeach
        </div>

        <div class="tcw-detail-heading text-center tcw-tech-heading">
          <h2><span>{{ __('website.portfolio_detail.highlights') }}</span></h2>
        </div>
        <div class="tcw-tech-grid">
          @foreach($techItems->take(8) as $tech)
            <div class="tcw-tech-card">
              <i class="fas fa-code-branch"></i>
              <span>{{ $tech }}</span>
            </div>
          @endforeach
        </div>

        <div class="tcw-detail-cta">
          <div>
            <h2>{{ __('website.portfolio_detail.cta_title') }}</h2>
            <p>{{ __('website.portfolio_detail.cta_text') }}</p>
            <a href="{{ url('/contact') }}" class="tcw-detail-btn tcw-detail-btn-light">{{ __('website.service_detail.consultation') }} <i class="fas fa-arrow-right"></i></a>
          </div>
          <div class="tcw-cta-stats">
            <div><i class="fas fa-users"></i><strong>120+</strong><span>{{ __('website.services.projects_completed') }}</span></div>
            <div><i class="fas fa-smile"></i><strong>50+</strong><span>{{ __('website.services.happy_clients') }}</span></div>
            <div><i class="fas fa-trophy"></i><strong>5+</strong><span>{{ __('website.services.years_experience') }}</span></div>
            <div><i class="fas fa-globe"></i><strong>10+</strong><span>{{ __('website.portfolio_detail.countries') }}</span></div>
          </div>
        </div>

      </div>
    </section>
  </main>
@endsection
