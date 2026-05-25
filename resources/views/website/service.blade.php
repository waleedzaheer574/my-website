@extends('layouts.website')

@section('title', __('website.services.title'))

@section('content')
@php
  $serviceIconMap = [
    'cloud' => 'fas fa-server',
    'devops' => 'fas fa-server',
    'e-commerce' => 'fas fa-shopping-cart',
    'ecommerce' => 'fas fa-shopping-cart',
    'erp' => 'fas fa-users',
    'crm' => 'fas fa-users',
    'automation' => 'fas fa-robot',
    'website' => 'fas fa-globe',
    'optimization' => 'fas fa-search-plus',
    'seo' => 'fas fa-search-location',
  ];

  $serviceFeatures = [
    'cloud' => ['AWS Setup & Management', 'CI/CD Pipeline Integration', 'Server Monitoring & Security', 'Scalable Cloud Architecture'],
    'devops' => ['AWS Setup & Management', 'CI/CD Pipeline Integration', 'Server Monitoring & Security', 'Scalable Cloud Architecture'],
    'e-commerce' => ['Custom eCommerce Solutions', 'Payment Gateway Integration', 'Inventory & Order Management', 'Shopify / WooCommerce Expert'],
    'ecommerce' => ['Custom eCommerce Solutions', 'Payment Gateway Integration', 'Inventory & Order Management', 'Shopify / WooCommerce Expert'],
    'erp' => ['Custom ERP Solutions', 'CRM Development', 'HR & Payroll Management', 'Workflow Automation'],
    'crm' => ['Custom ERP Solutions', 'CRM Development', 'HR & Payroll Management', 'Workflow Automation'],
    'automation' => ['AI Chatbot Development', 'Business Process Automation', 'AI Integration & APIs', 'Smart Workflow Automation'],
    'website' => ['Speed Optimization', 'Core Web Vitals Improvement', 'User Experience Enhancement', 'Conversion Rate Optimization'],
    'optimization' => ['Speed Optimization', 'Core Web Vitals Improvement', 'User Experience Enhancement', 'Conversion Rate Optimization'],
    'seo' => ['Keyword Research', 'On-Page & Off-Page SEO', 'Technical SEO Audit', 'Local SEO Optimization'],
  ];

  $fallbackIcons = ['fas fa-server', 'fas fa-shopping-cart', 'fas fa-users', 'fas fa-robot', 'fas fa-globe', 'fas fa-search-location'];

  $whyIcons = ['fas fa-user-shield', 'fas fa-chart-line', 'fas fa-headset', 'fas fa-database', 'fas fa-cogs'];
  $whyItems = collect(__('website.services.why_items'))->map(fn ($item, $index) => [
    'icon' => $whyIcons[$index],
    'title' => $item['title'],
    'text' => $item['text'],
  ])->all();

  $processIcons = ['fas fa-clipboard-list', 'fas fa-tasks', 'fas fa-briefcase', 'fas fa-flag'];
  $processItems = collect(__('website.services.process_items'))->map(fn ($item, $index) => [
    'icon' => $processIcons[$index],
    'step' => str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT),
    'title' => $item['title'],
    'text' => $item['text'],
  ])->all();

  $techItems = [
    ['icon' => 'fab fa-aws', 'label' => 'AWS'],
    ['icon' => 'fab fa-docker', 'label' => 'Docker'],
    ['icon' => 'fas fa-dharmachakra', 'label' => 'Kubernetes'],
    ['icon' => 'fab fa-laravel', 'label' => 'Laravel'],
    ['icon' => 'fab fa-react', 'label' => 'React'],
    ['icon' => 'fab fa-wordpress', 'label' => 'WordPress'],
    ['icon' => 'fab fa-shopify', 'label' => 'Shopify'],
    ['icon' => 'fab fa-node-js', 'label' => 'Node.js'],
  ];

  $serviceIconFor = function ($service, $index) use ($serviceIconMap, $fallbackIcons) {
    $title = strtolower($service->service_title ?? '');
    foreach ($serviceIconMap as $needle => $icon) {
      if (str_contains($title, $needle)) {
        return $icon;
      }
    }
    return $fallbackIcons[$index % count($fallbackIcons)];
  };

  $serviceFeaturesFor = function ($service) use ($serviceFeatures) {
    $title = strtolower($service->service_title ?? '');
    foreach ($serviceFeatures as $needle => $features) {
      if (str_contains($title, $needle)) {
        return $features;
      }
    }
    return ['Strategy & Planning', 'Custom Design', 'Professional Development', 'Quality Support'];
  };
@endphp

<main class="tcw-service-index">
  <section class="tcw-service-index-hero">
    <div class="container">
      <nav class="tcw-service-index-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('website.home') }}">{{ __('website.nav.home') }}</a>
        <i class="fas fa-chevron-right"></i>
        <span>{{ __('website.services.title') }}</span>
      </nav>
      <div class="tcw-service-index-heading">
        <h1>{{ __('website.services.all') }} <span>{{ __('website.services.title') }}</span></h1>
        <p>{{ __('website.services.intro') }}</p>
      </div>
    </div>
  </section>

  <section id="service-list" class="tcw-service-index-section">
    <div class="container">
      @if($services->isEmpty())
        <div class="text-center tcw-empty-state">
          <h2 class="tcw-empty-title">{{ __('website.services.empty_title') }}</h2>
          <p class="tcw-empty-text">{{ __('website.services.empty_text') }}</p>
        </div>
      @else
        <div class="tcw-service-index-grid" data-load-more-grid data-load-more-step="6">
          @foreach($services as $service)
            @php
              $serviceUrl = $service->detail
                ? route('website.service-details.show', $service->detail->slug)
                : route('website.services');
              $features = $serviceFeaturesFor($service);
            @endphp
            <article class="tcw-service-index-card tcw-load-more-item {{ $loop->index >= 6 ? 'is-hidden' : '' }}" data-load-more-item>
              <a href="{{ $serviceUrl }}">
                <span class="tcw-service-index-icon">
                  @if($service->icon)
                    <img src="{{ asset($service->icon) }}" alt="{{ $service->localized('service_title') }}" width="52" height="52" loading="lazy" decoding="async">
                  @else
                    <i class="{{ $serviceIconFor($service, $loop->index) }}"></i>
                  @endif
                </span>
                <h2>{{ $service->localized('service_title') }}</h2>
                <p>{{ \Illuminate\Support\Str::limit($service->localized('service_description'), 132) }}</p>
                <ul>
                  @foreach($features as $feature)
                    <li><i class="far fa-check-circle"></i>{{ $feature }}</li>
                  @endforeach
                </ul>
                <b>{{ __('website.services.explore') }} <i class="fas fa-arrow-right"></i></b>
              </a>
            </article>
          @endforeach
        </div>

        @if($services->count() > 6)
          <div class="tcw-load-more-wrap">
            <button type="button" class="tcw-load-more-btn" data-load-more-button>
              <i class="fas fa-sync-alt"></i> {{ __('website.services.load_more') }}
            </button>
          </div>
        @endif
      @endif

      <section class="tcw-service-why-panel">
        <h2>{{ __('website.services.why') }}</h2>
        <div>
          @foreach($whyItems as $item)
            <article>
              <i class="{{ $item['icon'] }}"></i>
              <h3>{{ $item['title'] }}</h3>
              <p>{{ $item['text'] }}</p>
            </article>
          @endforeach
        </div>
      </section>

      <section class="tcw-service-process-panel">
        <div class="tcw-service-index-heading is-small">
          <span>{{ __('website.services.process_label') }}</span>
          <h2>{{ __('website.services.process_title') }}</h2>
        </div>
        <div class="tcw-service-process-grid">
          @foreach($processItems as $item)
            <article>
              <i class="{{ $item['icon'] }}"></i>
              <b>{{ $item['step'] }}</b>
              <h3>{{ $item['title'] }}</h3>
              <p>{{ $item['text'] }}</p>
            </article>
          @endforeach
        </div>
      </section>

      <section class="tcw-service-tech-panel-index">
        <span>{{ __('website.services.technologies') }}</span>
        <div>
          @foreach($techItems as $tech)
            <article><i class="{{ $tech['icon'] }}"></i><b>{{ $tech['label'] }}</b></article>
          @endforeach
        </div>
      </section>

      <section class="tcw-service-index-cta">
        <div>
          <h2>{{ __('website.services.cta_title') }}</h2>
          <p>{{ __('website.services.cta_text') }}</p>
        </div>
        <div class="tcw-service-index-stats">
          <span><strong>120+</strong><small>{{ __('website.services.projects_completed') }}</small></span>
          <span><strong>50+</strong><small>{{ __('website.services.happy_clients') }}</small></span>
          <span><strong>5+</strong><small>{{ __('website.services.years_experience') }}</small></span>
        </div>
        <a href="{{ route('website.contact') }}">{{ __('website.services.consultation') }} <i class="fas fa-arrow-right"></i></a>
      </section>
    </div>
  </section>
</main>
@endsection
