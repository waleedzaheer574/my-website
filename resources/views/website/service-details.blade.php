@extends('layouts.website')

@section('title', trim(($serviceDetail->localized('title_prefix') ?? '') . ' ' . ($serviceDetail->localized('title_highlight') ?? __('website.service_detail.fallback_title'))))
@section('hide_global_faqs', '1')

@php
  $serviceTitle = trim(($serviceDetail->localized('title_prefix') ?? '') . ' ' . ($serviceDetail->localized('title_highlight') ?? __('website.service_detail.fallback_title')));
  $serviceName = trim(($serviceDetail->localized('title_highlight') ?? '') ?: $serviceTitle);
  $description = $serviceDetail->localized('description') ?: __('website.service_detail.fallback_description');
  $hasVideo = filled($serviceDetail->video_url);
  $videoPreviewImage = $serviceDetail->video_thumbnail ?: $serviceDetail->primary_image;
  $highlightText = trim($serviceDetail->localized('title_highlight') ?: __('website.services.title'));
  $highlightParts = preg_split('/\s+/', $highlightText) ?: [];
  $highlightTail = count($highlightParts) > 1 ? array_pop($highlightParts) : '';
  $highlightLead = trim(implode(' ', $highlightParts)) ?: $highlightText;
  $processItems = collect([
      ['title' => $serviceDetail->localized('process_one_title') ?: __('website.services.process_items.0.title'), 'text' => $serviceDetail->localized('process_one_text') ?: __('website.services.process_items.0.text'), 'icon' => 'fa-clipboard-list'],
      ['title' => $serviceDetail->localized('process_two_title') ?: __('website.services.process_items.1.title'), 'text' => $serviceDetail->localized('process_two_text') ?: __('website.services.process_items.1.text'), 'icon' => 'fa-code'],
      ['title' => $serviceDetail->localized('process_three_title') ?: __('website.services.process_items.2.title'), 'text' => $serviceDetail->localized('process_three_text') ?: __('website.services.process_items.2.text'), 'icon' => 'fa-rocket'],
  ])->filter(fn ($item) => $item['title'] || $item['text'])->values();

  $statItems = [
      ['value' => '120+', 'label' => __('website.services.projects_completed'), 'icon' => 'fa-rocket'],
      ['value' => '50+', 'label' => __('website.services.happy_clients'), 'icon' => 'fa-users'],
      ['value' => '5+', 'label' => __('website.services.years_experience'), 'icon' => 'fa-trophy'],
      ['value' => '24/7', 'label' => __('website.offer_detail.support'), 'icon' => 'fa-headset'],
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
          <a href="{{ url('/') }}">{{ __('website.nav.home') }}</a>
          <i class="fas fa-chevron-right"></i>
          <a href="{{ route('website.services') }}">{{ __('website.nav.services') }}</a>
          <i class="fas fa-chevron-right"></i>
          <span>{{ $serviceName }}</span>
        </nav>

        <div class="tcw-detail-hero-grid">
          <div class="tcw-detail-hero-copy">
            <span class="tcw-detail-eyebrow">{{ __('website.service_detail.professional') }}</span>
            <h1>{{ $serviceDetail->localized('title_prefix') ?: __('website.service_detail.digital') }} <span>{{ $highlightLead }}</span>@if($highlightTail) <b>{{ $highlightTail }}</b>@endif</h1>
            <p>{!! nl2br(e($description)) !!}</p>
            <div class="tcw-detail-actions">
              <a href="{{ url('/contact') }}" class="tcw-detail-btn tcw-detail-btn-primary">
                {{ __('website.service_detail.consultation') }} <i class="fas fa-arrow-right"></i>
              </a>
              <a href="{{ route('website.portfolio') }}" class="tcw-detail-btn tcw-detail-btn-outline">{{ __('website.service_detail.portfolio') }}</a>
            </div>
          </div>

          <div class="tcw-detail-hero-media cs-lightgallery">
            @php($heroImage = $serviceDetail->primary_image ?: 'website/assets/img/generated/home-hero-optimized.jpg')
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
          <span class="tcw-detail-eyebrow">{{ __('website.service_detail.workflow') }}</span>
          <h2>{{ __('website.service_detail.our') }} <span>{{ $serviceDetail->localized('process_heading') ?: __('website.service_detail.process') }}</span></h2>
          <p>{{ __('website.service_detail.process_text') }}</p>
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
              <span class="tcw-detail-eyebrow">{{ __('website.service_detail.what_get') }}</span>
              <h2>{{ __('website.service_detail.benefits') }} <span>{{ $serviceName }}</span></h2>
            </div>
            <p>{{ __('website.service_detail.benefit_text') }}</p>
            <ul class="tcw-benefit-list">
              @foreach($featureItems as $feature)
                <li><i class="fas fa-check"></i><span>{{ $feature['title'] }}</span></li>
              @endforeach
            </ul>
          </div>

          <div class="tcw-service-tech-panel">
            <div class="tcw-detail-heading">
              <span class="tcw-detail-eyebrow">{{ __('website.service_detail.technologies') }}</span>
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
            <h2>{{ __('website.service_detail.cta_title') }}</h2>
            <p>{{ __('website.service_detail.cta_text') }}</p>
          </div>
          <a href="{{ url('/contact') }}" class="tcw-detail-btn tcw-detail-btn-light">{{ __('website.service_detail.consultation') }} <i class="fas fa-arrow-right"></i></a>
        </div>

      </div>
    </section>
  </main>
@endsection
