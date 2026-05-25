@extends('layouts.website')

@section('title', $offer->localized('title'))
@section('hide_global_faqs', '1')

@section('content')
@php
  $slug = $offer->slug;
  $isEcommerce = str_contains($slug, 'ecommerce');
  $isSaas = str_contains($slug, 'saas') || str_contains($slug, 'laravel');
  $isSeo = str_contains($slug, 'seo');
  $isMobile = str_contains($slug, 'mobile') || str_contains($slug, 'app');

  $fallbackOverviewCards = $isEcommerce
      ? ['Modern & Responsive Design', 'SEO Friendly Structure', 'Easy Product Management', 'Secure Checkout System']
      : ($isSaas
          ? ['Scalable Laravel Architecture', 'User Dashboard', 'Subscription Ready', 'Admin Control Panel']
          : ($isSeo
              ? ['Technical SEO Audit', 'Keyword Planning', 'On-page Improvements', 'Monthly Reporting']
              : ['Responsive Interface', 'Clean User Journey', 'Fast Performance', 'Admin Friendly Setup']));

  $fallbackTopFeatures = collect($offer->localized('features') ?? [])->merge($isEcommerce ? [
      'Product catalog & categories',
      'Shopping cart & checkout',
      'Multiple payment gateways',
      'Order management system',
      'Customer account area',
      'Discounts & coupons',
      'Reviews & ratings',
      'Responsive on all devices',
  ] : [
      'Professional UI structure',
      'Dashboard-ready workflow',
      'Secure user experience',
      'Mobile responsive layout',
  ])->unique()->take(8)->values();

  $fallbackStack = $isSeo
      ? ['SEO Audit', 'Search Console', 'Analytics', 'Schema', 'Speed', 'Reports']
      : ($isMobile
          ? ['Flutter', 'Laravel API', 'MySQL', 'Firebase', 'Stripe', 'Admin Panel']
          : ['Laravel', 'MySQL', 'Blade', 'Tailwind CSS', 'Stripe', 'JavaScript', 'HTML5', 'CSS3']);

  $overviewCards = collect($offer->localized('overview_items') ?: $fallbackOverviewCards)->filter()->values();
  $topFeatures = collect($offer->localized('detail_features') ?: $fallbackTopFeatures->map(fn ($feature, $index) => [
      'title' => $feature,
      'description' => $index % 2 === 0 ? 'Smooth workflow with reliable controls.' : 'Built for modern business needs.',
  ])->all())->filter(fn ($item) => !empty($item['title']))->take(8)->values();
  $stack = collect($offer->tech_stack ?: $fallbackStack)->filter()->values();
  $timeline = collect($offer->localized('delivery_timeline') ?: [
      ['title' => 'Discovery', 'description' => 'Understanding your requirements.'],
      ['title' => 'Design', 'description' => 'Creating UI/UX designs.'],
      ['title' => 'Development', 'description' => 'Building your solution.'],
      ['title' => 'Review', 'description' => 'Testing and client review.'],
      ['title' => 'Launch', 'description' => 'Deploy and launch.'],
  ])->filter(fn ($item) => !empty($item['title']))->values();
  $faqs = collect($offer->localized('faqs') ?: [
      ['question' => 'Can I manage content easily?', 'answer' => 'Yes. After checkout, your dashboard will show project status, milestones, messages and delivery updates.'],
      ['question' => 'Will my website be mobile friendly?', 'answer' => 'Yes. Every package is built with responsive layouts for mobile, tablet and desktop screens.'],
      ['question' => 'Do you provide domain & hosting?', 'answer' => 'We can guide setup and connect your preferred domain and hosting during delivery.'],
      ['question' => 'Will I get support after delivery?', 'answer' => 'Yes. You can use your dashboard and support chat for updates after delivery.'],
  ])->filter(fn ($item) => !empty($item['question']))->values();
  $whyChoose = collect($offer->localized('why_choose') ?: [
      'Professional & modern designs',
      'On-time delivery',
      'Lifetime support',
      'Money back guarantee',
      '100% client satisfaction',
  ])->filter()->values();
  $overviewText = $offer->localized('detail_overview') ?: "This {$offer->localized('title')} package is perfect for businesses looking for a professional, scalable and conversion-focused digital experience. It includes everything you need to launch with confidence.";
  $heroVisualTitle = $offer->localized('hero_visual_title') ?: ($isEcommerce ? 'Super fast eCommerce experience' : 'Premium digital experience');
@endphp

<main class="tcw-saas-page tcw-offer-detail-page">
  <section class="tcw-premium-detail-hero">
    <div class="container">
      <nav class="tcw-detail-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ route('website.home') }}">{{ __('website.nav.home') }}</a>
        <i class="fas fa-chevron-right"></i>
        <a href="{{ route('website.offers') }}">{{ __('website.nav.offers') }}</a>
        <i class="fas fa-chevron-right"></i>
        <span>{{ $offer->localized('title') }}</span>
      </nav>

      <div class="tcw-detail-hero-grid">
        <div class="tcw-detail-copy">
          <span class="tcw-detail-kicker">{{ $offer->localized('category') ?: __('website.offer_detail.solution') }}</span>
          <h1>{{ $offer->localized('title') }}</h1>
          <p>{{ $offer->localized('description') }}</p>

          <div class="tcw-detail-mini-stats">
            <span><i class="far fa-clock"></i>{{ $offer->delivery_time ?: __('website.offer_detail.custom') }} {{ __('website.offer_detail.delivery') }}</span>
            <span><i class="fas fa-shield-alt"></i>{{ __('website.offer_detail.satisfaction') }}</span>
            <span><i class="fas fa-medal"></i>{{ __('website.offer_detail.money_back') }}</span>
            <span><i class="fas fa-headset"></i>{{ __('website.offer_detail.support') }}</span>
          </div>
        </div>

        <div class="tcw-detail-device" aria-hidden="true">
          <div class="tcw-detail-glow-ring"></div>
          <div class="tcw-detail-laptop">
            <div class="tcw-device-bar"></div>
            <div class="tcw-device-screen">
              <strong>{{ $heroVisualTitle }}</strong>
              <span></span>
              <small></small>
            </div>
          </div>
          <div class="tcw-detail-phone">
            <span></span><span></span><span></span>
          </div>
        </div>

        <aside class="tcw-detail-price-card">
          <span>{{ __('website.offer_detail.total_price') }}</span>
          <strong>{{ $offer->price_label }}</strong>
          <small>{{ $offer->billing_label }} | {{ $offer->delivery_time ?: __('website.offer_detail.timeline_after') }}</small>
          <a href="{{ route('website.checkout', $offer->slug) }}">{{ __('website.offer_detail.subscribe') }}</a>
          <ul>
            <li><i class="far fa-credit-card"></i>{{ __('website.offer_detail.secure_payment') }}</li>
            <li><i class="fas fa-check-circle"></i>{{ __('website.offer_detail.money_back') }}</li>
            <li><i class="fas fa-life-ring"></i>{{ __('website.offer_detail.support') }}</li>
          </ul>
          <div>
            <b>{{ __('website.offer_detail.custom_question') }}</b>
            <p>{{ __('website.offer_detail.custom_text') }}</p>
            <a href="{{ route('website.contact') }}">{{ __('website.offer_detail.contact') }} <i class="fas fa-arrow-right"></i></a>
          </div>
        </aside>
      </div>
    </div>
  </section>

  <section class="tcw-detail-content">
    <div class="container">
      <div class="tcw-detail-layout">
        <aside class="tcw-detail-side-nav">
          @foreach(['overview', 'features', 'stack', 'delivery_process', 'faq', 'reviews'] as $item)
            <a href="#{{ $item === 'stack' ? 'technology-stack' : ($item === 'delivery_process' ? 'delivery-process' : $item) }}" class="{{ $loop->first ? 'is-active' : '' }}">
              <i class="fas fa-caret-right"></i>{{ __('website.offer_detail.'.$item) }}
            </a>
          @endforeach
        </aside>

        <div class="tcw-detail-main">
          <section class="tcw-detail-panel" id="overview">
            <h2>{{ __('website.offer_detail.overview') }}</h2>
            <p>{{ $overviewText }}</p>
            <div class="tcw-overview-chip-grid">
              @foreach($overviewCards as $card)
                <span><i class="far fa-square"></i>{{ $card }}</span>
              @endforeach
            </div>
          </section>

          <section class="tcw-detail-panel" id="features">
            <h2>{{ __('website.offer_detail.top_features') }}</h2>
            <div class="tcw-detail-feature-grid">
              @foreach($topFeatures as $feature)
                <article>
                  <i class="fas fa-check"></i>
                  <div>
                    <h3>{{ $feature['title'] }}</h3>
                    <p>{{ $feature['description'] ?: 'Built for modern business needs.' }}</p>
                  </div>
                </article>
              @endforeach
            </div>
          </section>

          <section class="tcw-detail-panel" id="technology-stack">
            <h2>{{ __('website.offer_detail.stack') }}</h2>
            <div class="tcw-detail-stack">
              @foreach($stack as $tech)
                <span><i class="fas fa-cube"></i>{{ $tech }}</span>
              @endforeach
            </div>
          </section>

          <section class="tcw-detail-panel" id="delivery-process">
            <h2>{{ __('website.offer_detail.timeline') }}</h2>
            <div class="tcw-detail-timeline">
              @foreach($timeline as $step)
                <article>
                  <b>{{ $loop->iteration }}</b>
                  <h3>{{ $step['title'] }}</h3>
                  <p>{{ $step['description'] ?: __('website.offer_detail.timeline_after') }}</p>
                </article>
              @endforeach
            </div>
            <div class="tcw-detail-timeline-note">
              <span><i class="far fa-clock"></i>{{ __('website.offer_detail.total_time') }}: {{ $offer->delivery_time ?: __('website.offer_detail.timeline_after') }}</span>
              <span><i class="fas fa-bullseye"></i>{{ __('website.offer_detail.on_time') }}</span>
            </div>
          </section>
        </div>

        <aside class="tcw-detail-right">
          <section class="tcw-detail-panel tcw-why-card">
            <h2>{{ __('website.offer_detail.why') }}</h2>
            <ul>
              @foreach($whyChoose as $reason)
                <li><i class="fas fa-check"></i>{{ $reason }}</li>
              @endforeach
            </ul>
            <div class="tcw-cart-visual"><i class="fas fa-shopping-cart"></i></div>
          </section>

          <section class="tcw-detail-panel" id="faq">
            <h2>{{ __('website.offer_detail.faq') }}</h2>
            <div class="tcw-detail-faq">
              @foreach($faqs as $faq)
                <details>
                  <summary>{{ $faq['question'] }}</summary>
                  <p>{{ $faq['answer'] ?: 'Our team will confirm the details after checkout.' }}</p>
                </details>
              @endforeach
            </div>
            <a href="{{ route('website.contact') }}" class="tcw-view-faqs">{{ __('website.offer_detail.all_faqs') }} <i class="fas fa-arrow-right"></i></a>
          </section>
        </aside>
      </div>

      @if($relatedOffers->isNotEmpty())
        <section class="tcw-detail-panel tcw-related-offers" id="reviews">
          <h2>{{ __('website.offer_detail.related') }}</h2>
          <div class="tcw-related-offer-grid">
            @foreach($relatedOffers as $related)
              <a href="{{ route('website.offers.show', $related->slug) }}">
                @if($related->is_popular)<b>{{ __('website.offer_detail.popular') }}</b>@endif
                <span>{{ $related->localized('category') ?: __('website.offer_detail.offer') }}</span>
                <h3>{{ $related->localized('title') }}</h3>
                <strong>{{ $related->price_label }}</strong>
                <small>{{ $related->delivery_time ?: __('website.offer_detail.custom_timeline') }}</small>
              </a>
            @endforeach
          </div>
        </section>
      @endif
    </div>
  </section>
</main>
@endsection
