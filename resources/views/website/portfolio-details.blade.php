@extends('layouts.website')

@section('title', $portfolio->title)
@section('hide_global_faqs', '1')

@php
  $description = $portfolio->description ?: $portfolio->short_description ?: 'Project details will be updated soon.';
  $gallery = collect([$portfolio->image, $portfolio->secondary_image, $portfolio->detail_image])->filter()->unique()->values();
  $tags = collect(explode(',', (string) $portfolio->tags))->map(fn ($tag) => trim($tag))->filter()->values();
  $techItems = $tags->isNotEmpty() ? $tags : collect(array_filter([$portfolio->category, 'UI/UX', 'Development', 'Responsive Design', 'Performance']));
  $rawDemoUrl = trim((string) $portfolio->demo_url);
  $demoUrl = $rawDemoUrl !== '' ? $rawDemoUrl : 'Available on request';
  $demoHref = $rawDemoUrl !== ''
    ? (\Illuminate\Support\Str::startsWith($rawDemoUrl, ['http://', 'https://']) ? $rawDemoUrl : 'https://' . $rawDemoUrl)
    : null;
@endphp

@section('content')
  <main class="tcw-detail-modern tcw-portfolio-modern">
    <section class="tcw-detail-hero">
      <div class="container">
        <nav class="tcw-detail-breadcrumb" aria-label="Breadcrumb">
          <a href="{{ url('/') }}">Home</a>
          <i class="fas fa-chevron-right"></i>
          <a href="{{ route('website.portfolio') }}">Portfolio</a>
          <i class="fas fa-chevron-right"></i>
          <span>{{ $portfolio->title }}</span>
        </nav>

        <div class="tcw-detail-hero-grid">
          <div class="tcw-detail-hero-copy">
            <span class="tcw-detail-eyebrow">Featured Case Study</span>
            <h1>{{ $portfolio->title }} <span>{{ $portfolio->category ?: 'Project' }}</span></h1>
            <p>{{ $portfolio->short_description ?: \Illuminate\Support\Str::limit(strip_tags($description), 190) }}</p>
          </div>

          <div class="tcw-detail-hero-media tcw-portfolio-device cs-lightgallery">
            <a href="{{ asset($portfolio->image) }}" class="tcw-service-image-link cs-lightbox-item" aria-label="Open full portfolio image">
              <img src="{{ asset($portfolio->image) }}" alt="{{ $portfolio->title }}" width="720" height="540" loading="eager" decoding="async" fetchpriority="high">
              <span class="tcw-blog-image-zoom"><i class="fas fa-search-plus"></i></span>
            </a>
          </div>

          <div class="tcw-detail-actions">
            <a href="{{ $demoHref ?: url('/contact') }}" class="tcw-detail-btn tcw-detail-btn-primary" @if($demoHref) target="_blank" rel="noopener" @endif>
              {{ $portfolio->demo_url ? 'Launch Website' : 'Start Similar Project' }} <i class="fas fa-arrow-right"></i>
            </a>
            <a href="{{ route('website.portfolio') }}" class="tcw-detail-btn tcw-detail-btn-outline">View Portfolio <i class="far fa-eye"></i></a>
          </div>
        </div>
      </div>
    </section>

    <section class="tcw-detail-section">
      <div class="container">
        <div class="tcw-detail-heading text-center">
          <span class="tcw-detail-eyebrow">Our Process</span>
          <h2>How We <span>Work</span></h2>
        </div>
        <div class="tcw-process-grid">
          <article class="tcw-process-card">
            <div class="tcw-process-icon"><i class="fas fa-lightbulb"></i></div>
            <span>01</span>
            <h3>Discovery & Strategy</h3>
            <p>We clarified the audience, goals, and conversion path before shaping the experience.</p>
          </article>
          <article class="tcw-process-card">
            <div class="tcw-process-icon"><i class="fas fa-pencil-ruler"></i></div>
            <span>02</span>
            <h3>UI/UX & Development</h3>
            <p>The interface was designed and built to feel clear, responsive, and easy to use.</p>
          </article>
          <article class="tcw-process-card">
            <div class="tcw-process-icon"><i class="fas fa-rocket"></i></div>
            <span>03</span>
            <h3>Testing & Launch</h3>
            <p>We reviewed performance, responsiveness, and core flows before final delivery.</p>
          </article>
        </div>
      </div>
    </section>

    <section class="tcw-detail-section tcw-about-detail-section">
      <div class="container">
        <div class="tcw-about-detail-grid">
          <div>
            <div class="tcw-detail-heading">
              <span class="tcw-detail-eyebrow">About The Project</span>
              <h2>Project <span>Overview</span></h2>
            </div>
            <div class="tcw-detail-richtext">{!! nl2br(e($description)) !!}</div>
            <div class="tcw-feature-mini-grid tcw-portfolio-facts">
              <div class="tcw-feature-mini"><i class="fas fa-user-tie"></i><div><h4>Client</h4><p>{{ $portfolio->client ?: 'N/A' }}</p></div></div>
              <div class="tcw-feature-mini"><i class="fas fa-layer-group"></i><div><h4>Category</h4><p>{{ $portfolio->category ?: 'N/A' }}</p></div></div>
              <div class="tcw-feature-mini"><i class="fas fa-clock"></i><div><h4>Duration</h4><p>{{ $portfolio->duration ?: 'N/A' }}</p></div></div>
              <div class="tcw-feature-mini"><i class="fas fa-layer-group"></i><div><h4>Services</h4><p>{{ $portfolio->tags ?: ($portfolio->category ?: 'N/A') }}</p></div></div>
              <div class="tcw-feature-mini tcw-portfolio-demo-fact"><i class="fas fa-link"></i><div><h4>Demo Link</h4><p>@if($demoHref)<a href="{{ $demoHref }}" target="_blank" rel="noopener noreferrer">{{ $demoUrl }}</a>@else{{ $demoUrl }}@endif</p></div></div>
            </div>
          </div>

          <div>
            <div class="tcw-detail-video tcw-portfolio-preview cs-lightgallery">
              @php($portfolioPreviewImage = $portfolio->secondary_image ?: $portfolio->image)
              <a href="{{ asset($portfolioPreviewImage) }}" class="tcw-service-image-link cs-lightbox-item" aria-label="Open full portfolio preview image">
                <img src="{{ asset($portfolioPreviewImage) }}" alt="{{ $portfolio->title }} preview" width="720" height="405" loading="lazy" decoding="async">
                <span class="tcw-blog-image-zoom"><i class="fas fa-search-plus"></i></span>
              </a>
            </div>
            <div class="tcw-detail-info-card">
              <div><i class="fas fa-user-tie"></i><strong>Client</strong><span>{{ $portfolio->client ?: 'N/A' }}</span></div>
              <div><i class="fas fa-layer-group"></i><strong>Category</strong><span>{{ $portfolio->category ?: 'N/A' }}</span></div>
              <div><i class="fas fa-clock"></i><strong>Duration</strong><span>{{ $portfolio->duration ?: 'N/A' }}</span></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="tcw-detail-section pt-0">
      <div class="container">
        <div class="tcw-detail-heading text-center">
          <h2><span>Project Gallery</span></h2>
        </div>
        <div class="tcw-project-gallery cs-lightgallery">
          @foreach($gallery as $image)
            <div>
              <a href="{{ asset($image) }}" class="tcw-service-image-link cs-lightbox-item" aria-label="Open portfolio gallery image {{ $loop->iteration }}">
                <img src="{{ asset($image) }}" alt="{{ $portfolio->title }} image {{ $loop->iteration }}" width="720" height="480" loading="lazy" decoding="async">
                <span class="tcw-blog-image-zoom"><i class="fas fa-search-plus"></i></span>
              </a>
            </div>
          @endforeach
        </div>

        <div class="tcw-detail-heading text-center tcw-tech-heading">
          <h2><span>Technologies & Highlights</span></h2>
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
            <h2>Ready To Build A Project Like This?</h2>
            <p>Let's create something polished, fast, and built around your goals.</p>
            <a href="{{ url('/contact') }}" class="tcw-detail-btn tcw-detail-btn-light">Get Free Consultation <i class="fas fa-arrow-right"></i></a>
          </div>
          <div class="tcw-cta-stats">
            <div><i class="fas fa-users"></i><strong>120+</strong><span>Projects Completed</span></div>
            <div><i class="fas fa-smile"></i><strong>50+</strong><span>Happy Clients</span></div>
            <div><i class="fas fa-trophy"></i><strong>5+</strong><span>Years Experience</span></div>
            <div><i class="fas fa-globe"></i><strong>10+</strong><span>Countries Served</span></div>
          </div>
        </div>

      </div>
    </section>
  </main>
@endsection
