@extends('layouts.website')

@section('title', trim(($serviceDetail->title_prefix ?? '') . ' ' . ($serviceDetail->title_highlight ?? 'Service Details')))
@section('hide_global_faqs', '1')

@php
  $serviceTitle = trim(($serviceDetail->title_prefix ?? '') . ' ' . ($serviceDetail->title_highlight ?? 'Service Details'));
  $serviceName = trim(($serviceDetail->title_highlight ?? '') ?: $serviceTitle);
  $description = $serviceDetail->description ?: 'We build modern, responsive and high-performance digital solutions that help businesses grow online.';
  $hasVideo = filled($serviceDetail->video_url);
  $videoPreviewImage = $serviceDetail->video_thumbnail ?: $serviceDetail->primary_image;
  $processItems = collect([
      ['title' => $serviceDetail->process_one_title ?: 'Planning & Strategy', 'text' => $serviceDetail->process_one_text ?: 'We analyze your goals, audience, and requirements to create a clear roadmap for success.', 'icon' => 'fa-clipboard-list'],
      ['title' => $serviceDetail->process_two_title ?: 'Design & Development', 'text' => $serviceDetail->process_two_text ?: 'Our team creates polished user experiences and builds scalable, high-performance solutions.', 'icon' => 'fa-code'],
      ['title' => $serviceDetail->process_three_title ?: 'Testing & Launch', 'text' => $serviceDetail->process_three_text ?: 'We test performance, responsiveness, and quality before launch so everything runs smoothly.', 'icon' => 'fa-rocket'],
  ])->filter(fn ($item) => $item['title'] || $item['text'])->values();

  $techItems = ['Laravel', 'PHP', 'Vue.js', 'React', 'MySQL', 'REST API', 'AWS', 'Docker'];
  $featureItems = [
      ['title' => 'Responsive Design', 'text' => 'Perfect display on all devices and screen sizes.', 'icon' => 'fa-mobile-screen-button'],
      ['title' => 'High Performance', 'text' => 'Optimized code and fast loading speed.', 'icon' => 'fa-gauge-high'],
      ['title' => 'Secure & Reliable', 'text' => 'Industry-standard security and data protection.', 'icon' => 'fa-shield-halved'],
      ['title' => 'Scalable Solutions', 'text' => 'Built to grow with your business needs.', 'icon' => 'fa-diagram-project'],
  ];
@endphp

@section('content')
  <main class="tcw-detail-modern tcw-service-modern">
    <section class="tcw-detail-hero">
      <div class="container">
        <nav class="tcw-detail-breadcrumb" aria-label="Breadcrumb">
          <a href="{{ url('/') }}">Home</a>
          <i class="fas fa-chevron-right"></i>
          <a href="{{ route('website.services') }}">Services</a>
          <i class="fas fa-chevron-right"></i>
          <span>{{ $serviceName }}</span>
        </nav>

        <div class="tcw-detail-hero-grid">
          <div class="tcw-detail-hero-copy">
            <span class="tcw-detail-eyebrow">Our Professional</span>
            <h1>{{ $serviceDetail->title_prefix ?: 'Digital' }} <span>{{ $serviceDetail->title_highlight ?: 'Services' }}</span></h1>
            <p>{!! nl2br(e($description)) !!}</p>
            <div class="tcw-detail-actions">
              <a href="{{ url('/contact') }}" class="tcw-detail-btn tcw-detail-btn-primary">
                Get Free Consultation <i class="fas fa-arrow-right"></i>
              </a>
              <a href="{{ route('website.portfolio') }}" class="tcw-detail-btn tcw-detail-btn-outline">View Portfolio</a>
            </div>
          </div>

          <div class="tcw-detail-hero-media cs-lightgallery">
            @php($heroImage = $serviceDetail->primary_image ?: 'website/assets/img/design-agency/hero-img.png')
            <a href="{{ asset($heroImage) }}" class="tcw-service-image-link cs-lightbox-item" aria-label="Open full service image">
              <img src="{{ asset($heroImage) }}" alt="{{ $serviceTitle }}" width="720" height="540" loading="eager" decoding="async" fetchpriority="high">
              <span class="tcw-blog-image-zoom"><i class="fas fa-search-plus"></i></span>
            </a>
          </div>
        </div>
      </div>
    </section>

    <section class="tcw-detail-section">
      <div class="container">
        <div class="tcw-detail-heading text-center">
          <h2>Our <span>{{ $serviceDetail->process_heading ?: 'Development Process' }}</span></h2>
        </div>
        <div class="tcw-process-grid">
          @foreach($processItems as $index => $item)
            <article class="tcw-process-card">
              <div class="tcw-process-icon"><i class="fas {{ $item['icon'] }}"></i></div>
              <span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
              <h3>{{ $item['title'] }}</h3>
              <p>{{ $item['text'] }}</p>
            </article>
          @endforeach
        </div>
      </div>
    </section>

    <section class="tcw-detail-section tcw-about-detail-section">
      <div class="container">
        <div class="tcw-about-detail-grid {{ $hasVideo ? 'has-video' : 'has-no-video' }}">
          <div>
            <div class="tcw-detail-heading">
              <h2>About Our <span>{{ $serviceName }}</span></h2>
            </div>
            <div class="tcw-detail-richtext">{!! nl2br(e($description)) !!}</div>
            <div class="tcw-feature-mini-grid">
              @foreach($featureItems as $feature)
                <div class="tcw-feature-mini">
                  <div>
                    <h4>{{ $feature['title'] }}</h4>
                    <p>{{ $feature['text'] }}</p>
                  </div>
                </div>
              @endforeach
            </div>
          </div>

          <div>
            @if($hasVideo && $videoPreviewImage)
              <div class="tcw-detail-video cs-lightgallery">
                <a href="{{ asset($videoPreviewImage) }}" class="tcw-service-image-link cs-lightbox-item" aria-label="Open full video preview image">
                  <img src="{{ asset($videoPreviewImage) }}" alt="{{ $serviceTitle }} video" width="720" height="405" loading="lazy" decoding="async">
                  <span class="tcw-blog-image-zoom"><i class="fas fa-search-plus"></i></span>
                </a>
                <a href="{{ $serviceDetail->video_url }}" class="cs-video_open tcw-video-play" aria-label="Play service video"><i class="fas fa-play"></i></a>
              </div>
            @endif

            <div class="tcw-detail-info-card">
              <div><i class="fas fa-screwdriver-wrench"></i><strong>Technologies</strong><span>{{ implode(', ', array_slice($techItems, 0, 5)) }}</span></div>
              <div><i class="fas fa-calendar-check"></i><strong>Development Time</strong><span>2 - 6 Weeks (Depending on Project Size)</span></div>
              <div><i class="fas fa-layer-group"></i><strong>Service Type</strong><span>{{ $serviceName }}</span></div>
              <div><i class="fas fa-headset"></i><strong>Support</strong><span>3 Months Free Support</span></div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="tcw-detail-section pt-0">
      <div class="container">
        <div class="tcw-detail-heading text-center">
          <h2>Technologies <span>We Use</span></h2>
        </div>
        <div class="tcw-tech-grid">
          @foreach($techItems as $tech)
            <div class="tcw-tech-card">
              <i class="fas fa-code"></i>
              <span>{{ $tech }}</span>
            </div>
          @endforeach
        </div>

        <div class="tcw-detail-cta">
          <div>
            <h2>Ready To Build Your Next Digital Product?</h2>
            <p>Let's create something amazing together.</p>
            <a href="{{ url('/contact') }}" class="tcw-detail-btn tcw-detail-btn-light">Get Free Consultation <i class="fas fa-arrow-right"></i></a>
          </div>
          <div class="tcw-cta-stats">
            <div><i class="fas fa-users"></i><strong>120+</strong><span>Projects Completed</span></div>
            <div><i class="fas fa-face-smile"></i><strong>50+</strong><span>Happy Clients</span></div>
            <div><i class="fas fa-trophy"></i><strong>5+</strong><span>Years Experience</span></div>
            <div><i class="fas fa-globe"></i><strong>10+</strong><span>Countries Served</span></div>
          </div>
        </div>

      </div>
    </section>
  </main>
@endsection
