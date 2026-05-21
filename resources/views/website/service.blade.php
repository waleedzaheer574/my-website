@extends('layouts.website')

@section('title', 'Services')

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

  $whyItems = [
    ['icon' => 'fas fa-user-shield', 'title' => 'Expert Team', 'text' => 'Skilled professionals with proven experience'],
    ['icon' => 'fas fa-chart-line', 'title' => 'Results Driven', 'text' => 'We focus on measurable growth and ROI'],
    ['icon' => 'fas fa-headset', 'title' => '24/7 Support', 'text' => 'Round-the-clock support and communication'],
    ['icon' => 'fas fa-database', 'title' => 'Custom Solutions', 'text' => 'Tailored solutions for your unique business needs'],
    ['icon' => 'fas fa-cogs', 'title' => 'Advanced Tools', 'text' => 'We use the latest tools and technologies'],
  ];

  $processItems = [
    ['icon' => 'fas fa-clipboard-list', 'step' => '01', 'title' => 'Discover', 'text' => 'We understand your business goals, challenges, and requirements.'],
    ['icon' => 'fas fa-tasks', 'step' => '02', 'title' => 'Plan & Strategy', 'text' => 'We create a powerful strategy and roadmap customized for your needs.'],
    ['icon' => 'fas fa-briefcase', 'step' => '03', 'title' => 'Execute', 'text' => 'Our team executes the plan using best practices and modern technologies.'],
    ['icon' => 'fas fa-flag', 'step' => '04', 'title' => 'Deliver Results', 'text' => 'We deliver measurable results and continuous improvement.'],
  ];

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
        <a href="{{ route('website.home') }}">Home</a>
        <i class="fas fa-chevron-right"></i>
        <span>Services</span>
      </nav>
      <div class="tcw-service-index-heading">
        <h1>All <span>Services</span></h1>
        <p>We provide end-to-end digital solutions to help your business grow, scale, and succeed in the modern world.</p>
      </div>
    </div>
  </section>

  <section id="service-list" class="tcw-service-index-section">
    <div class="container">
      @if($services->isEmpty())
        <div class="text-center tcw-empty-state">
          <h2 class="tcw-empty-title">No services available yet</h2>
          <p class="tcw-empty-text">Admin panel se services add karne ke baad ye section automatically populate ho jayega.</p>
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
                    <img src="{{ asset($service->icon) }}" alt="{{ $service->service_title }}" width="52" height="52" loading="lazy" decoding="async">
                  @else
                    <i class="{{ $serviceIconFor($service, $loop->index) }}"></i>
                  @endif
                </span>
                <h2>{{ $service->service_title }}</h2>
                <p>{{ \Illuminate\Support\Str::limit($service->service_description, 132) }}</p>
                <ul>
                  @foreach($features as $feature)
                    <li><i class="far fa-check-circle"></i>{{ $feature }}</li>
                  @endforeach
                </ul>
                <b>Explore Service <i class="fas fa-arrow-right"></i></b>
              </a>
            </article>
          @endforeach
        </div>

        @if($services->count() > 6)
          <div class="tcw-load-more-wrap">
            <button type="button" class="tcw-load-more-btn" data-load-more-button>
              <i class="fas fa-sync-alt"></i> Load More Services
            </button>
          </div>
        @endif
      @endif

      <section class="tcw-service-why-panel">
        <h2>Why Choose Multitechwave?</h2>
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
          <span>Our Work Process</span>
          <h2>Our Simple 4-Step Process</h2>
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
        <span>Technologies We Use</span>
        <div>
          @foreach($techItems as $tech)
            <article><i class="{{ $tech['icon'] }}"></i><b>{{ $tech['label'] }}</b></article>
          @endforeach
        </div>
      </section>

      <section class="tcw-service-index-cta">
        <div>
          <h2>Ready to Start Your Next Project?</h2>
          <p>Let's build something amazing together. Get in touch with us and take your business to the next level.</p>
        </div>
        <div class="tcw-service-index-stats">
          <span><strong>120+</strong><small>Projects Completed</small></span>
          <span><strong>50+</strong><small>Happy Clients</small></span>
          <span><strong>5+</strong><small>Years of Experience</small></span>
        </div>
        <a href="{{ route('website.contact') }}">Get Free Consultation <i class="fas fa-arrow-right"></i></a>
      </section>
    </div>
  </section>
</main>
@endsection
