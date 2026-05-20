@extends('layouts.website')

@section('title', trim(($serviceDetail->title_prefix ?? '') . ' ' . ($serviceDetail->title_highlight ?? 'Service Details')))
@section('hide_global_faqs', '1')

@php
  $serviceTitle = trim(($serviceDetail->title_prefix ?? '') . ' ' . ($serviceDetail->title_highlight ?? 'Service Details'));
  $serviceName = trim(($serviceDetail->title_highlight ?? '') ?: $serviceTitle);
  $description = $serviceDetail->description ?: 'We build modern, responsive and high-performance digital solutions that help businesses grow online.';
  $hasVideo = filled($serviceDetail->video_url);
  $videoPreviewImage = $serviceDetail->video_thumbnail ?: $serviceDetail->primary_image;
  $highlightText = trim($serviceDetail->title_highlight ?: 'Services');
  $highlightParts = preg_split('/\s+/', $highlightText) ?: [];
  $highlightTail = count($highlightParts) > 1 ? array_pop($highlightParts) : '';
  $highlightLead = trim(implode(' ', $highlightParts)) ?: $highlightText;
  $processItems = collect([
      ['title' => $serviceDetail->process_one_title ?: 'Planning & Strategy', 'text' => $serviceDetail->process_one_text ?: 'We analyze your goals, audience, and requirements to create a clear roadmap for success.', 'icon' => 'fa-clipboard-list'],
      ['title' => $serviceDetail->process_two_title ?: 'Design & Development', 'text' => $serviceDetail->process_two_text ?: 'Our team creates polished user experiences and builds scalable, high-performance solutions.', 'icon' => 'fa-code'],
      ['title' => $serviceDetail->process_three_title ?: 'Testing & Launch', 'text' => $serviceDetail->process_three_text ?: 'We test performance, responsiveness, and quality before launch so everything runs smoothly.', 'icon' => 'fa-rocket'],
  ])->filter(fn ($item) => $item['title'] || $item['text'])->values();

  $statItems = [
      ['value' => '120+', 'label' => 'Projects Delivered', 'icon' => 'fa-rocket'],
      ['value' => '50+', 'label' => 'Happy Clients', 'icon' => 'fa-users'],
      ['value' => '5+', 'label' => 'Years Experience', 'icon' => 'fa-trophy'],
      ['value' => '24/7', 'label' => 'Support', 'icon' => 'fa-headset'],
  ];
  $techItems = [
      ['label' => 'AWS', 'icon' => 'fab fa-aws', 'tone' => 'orange'],
      ['label' => 'Docker', 'icon' => 'fab fa-docker', 'tone' => 'cyan'],
      ['label' => 'Kubernetes', 'icon' => 'fas fa-dharmachakra', 'tone' => 'blue'],
      ['label' => 'GitHub Actions', 'icon' => 'fas fa-network-wired', 'tone' => 'sky'],
      ['label' => 'Terraform', 'icon' => 'fas fa-cubes', 'tone' => 'violet'],
      ['label' => 'Jenkins', 'icon' => 'fab fa-jenkins', 'tone' => 'cream'],
      ['label' => 'Prometheus', 'icon' => 'fas fa-fire', 'tone' => 'red'],
      ['label' => 'Grafana', 'icon' => 'fas fa-chart-line', 'tone' => 'orange'],
  ];
  $featureItems = [
      ['title' => 'High Performance & Scalability', 'icon' => 'fa-gauge-high'],
      ['title' => 'Secure & Reliable Infrastructure', 'icon' => 'fa-shield-halved'],
      ['title' => 'Cost Optimization', 'icon' => 'fa-circle-dollar-to-slot'],
      ['title' => 'Automated Workflows', 'icon' => 'fa-gears'],
      ['title' => '24/7 Monitoring & Support', 'icon' => 'fa-headset'],
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
            <span class="tcw-detail-eyebrow">Our Professional Service</span>
            <h1>{{ $serviceDetail->title_prefix ?: 'Digital' }} <span>{{ $highlightLead }}</span>@if($highlightTail) <b>{{ $highlightTail }}</b>@endif</h1>
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

        <div class="tcw-service-stats">
          @foreach($statItems as $stat)
            <article>
              <i class="fas {{ $stat['icon'] }}" aria-hidden="true"></i>
              <strong>{{ $stat['value'] }}</strong>
              <span>{{ $stat['label'] }}</span>
            </article>
          @endforeach
        </div>
      </div>
    </section>

    <section class="tcw-detail-section">
      <div class="container">
        <div class="tcw-detail-heading text-center">
          <span class="tcw-detail-eyebrow">Our Workflow</span>
          <h2>Our <span>{{ $serviceDetail->process_heading ?: 'Development Process' }}</span></h2>
          <p>We follow a proven process to deliver robust and scalable cloud solutions.</p>
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
        <div class="tcw-benefits-tech-grid">
          <div class="tcw-benefits-panel">
            <div class="tcw-detail-heading">
              <span class="tcw-detail-eyebrow">What You Get</span>
              <h2>Benefits of Our <span>{{ $serviceName }}</span></h2>
            </div>
            <p>We deliver modern cloud solutions that help your business scale, perform, and grow without limits.</p>
            <ul class="tcw-benefit-list">
              @foreach($featureItems as $feature)
                <li><i class="fas fa-check"></i><span>{{ $feature['title'] }}</span></li>
              @endforeach
            </ul>
          </div>

          <div class="tcw-service-tech-panel">
            <div class="tcw-detail-heading">
              <span class="tcw-detail-eyebrow">Technologies We Use</span>
            </div>
            <div class="tcw-tech-grid">
              @foreach($techItems as $tech)
                <div class="tcw-tech-card is-{{ $tech['tone'] }}">
                  <i class="{{ $tech['icon'] }}"></i>
                  <span>{{ $tech['label'] }}</span>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="tcw-detail-section pt-0">
      <div class="container">
        <div class="tcw-detail-cta">
          <div>
            <h2>Ready To Build Your Next Digital Product?</h2>
            <p>Let's create something amazing together.</p>
          </div>
          <a href="{{ url('/contact') }}" class="tcw-detail-btn tcw-detail-btn-light">Get Free Consultation <i class="fas fa-arrow-right"></i></a>
        </div>

      </div>
    </section>
  </main>
@endsection
