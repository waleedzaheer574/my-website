@extends('layouts.website')

@section('title', 'Offers & Pricing')
@section('hide_global_faqs', '1')

@section('content')
@php
  $offerMeta = [
      '5-page-dynamic-website' => ['icon' => 'fa-regular fa-window-maximize', 'badge' => 'Best Seller', 'old_price' => 'AED 300', 'tone' => 'blue'],
      'ecommerce-website' => ['icon' => 'fas fa-shopping-cart', 'badge' => 'Popular', 'old_price' => 'AED 1,600', 'tone' => 'pink'],
      'laravel-saas-system' => ['icon' => 'fas fa-code', 'badge' => 'Most Popular', 'old_price' => 'AED 4,500', 'tone' => 'purple', 'featured' => true],
      'seo-starter-package' => ['icon' => 'fas fa-search-location', 'old_price' => 'AED 250', 'tone' => 'violet'],
      'mobile-app-development' => ['icon' => 'fas fa-mobile-alt', 'old_price' => 'AED 1,200', 'tone' => 'pink'],
  ];

  $categories = collect(['All Offers'])
      ->merge($offers->pluck('category')->filter()->unique()->values())
      ->when(!$offers->pluck('category')->contains('Design'), fn ($items) => $items->push('Design'))
      ->when(!$offers->pluck('category')->contains('SaaS Solutions'), fn ($items) => $items->push('SaaS Solutions'))
      ->values();
@endphp

<main class="tcw-saas-page tcw-offers-page">
  <section class="tcw-offers-hero">
    <div class="container">
      <div class="tcw-offers-hero-grid">
        <div class="tcw-offers-hero-copy">
          <h1>Our Exclusive <span>Offers</span></h1>
          <p class="tcw-offers-lead">Choose the perfect solution for your business</p>
          <p>High-quality digital services at the best prices. Select an offer and start your journey with us today.</p>
        </div>
        <div class="tcw-offers-visual" aria-hidden="true">
          <span class="tcw-offers-orb is-one"></span>
          <span class="tcw-offers-orb is-two"></span>
          <span class="tcw-offers-orb is-three"></span>
          <div class="tcw-offers-stage">
            <div class="tcw-offers-tag"><i class="fas fa-percent"></i></div>
            <div class="tcw-offers-gift"><i class="fas fa-gift"></i></div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="tcw-offers-catalog" id="offers">
    <div class="container">
      <div class="tcw-offers-toolbar">
        <div class="tcw-offers-filters" aria-label="Offer categories">
          @foreach($categories as $category)
            <a href="#offers" class="{{ $loop->first ? 'is-active' : '' }}" data-offer-category="{{ $category }}">{{ $category }}</a>
          @endforeach
        </div>
        <div class="tcw-billing-toggle" aria-label="Billing options">
          <span>Monthly</span>
          <b>One Time</b>
        </div>
      </div>

      <div class="tcw-offer-grid">
        @foreach($offers as $offer)
          @php
            $meta = $offerMeta[$offer->slug] ?? [];
            $isFeatured = (bool) ($meta['featured'] ?? false);
            $badge = $meta['badge'] ?? ($offer->is_popular ? 'Popular' : null);
            $icon = $meta['icon'] ?? 'fas fa-layer-group';
            $tone = $meta['tone'] ?? 'blue';
          @endphp
          <article class="tcw-offer-card tcw-premium-offer-card {{ $isFeatured ? 'is-featured' : '' }}" data-offer-card data-offer-category="{{ $offer->category ?: 'Uncategorized' }}">
            <div class="tcw-offer-card-top">
              <span class="tcw-offer-icon is-{{ $tone }}"><i class="{{ $icon }}"></i></span>
              @if($badge)
                <b class="tcw-offer-badge">{{ $badge }}</b>
              @endif
            </div>
            <h3>{{ $offer->title }}</h3>
            <p>{{ $offer->description }}</p>
            <div class="tcw-offer-price">
              <strong>{{ $offer->price_label }}</strong>
              @if(!empty($meta['old_price']))
                <small>{{ $meta['old_price'] }}</small>
              @endif
            </div>
            <ul>
              @foreach(array_slice($offer->features ?? [], 0, 6) as $feature)
                <li><i class="fas fa-check-circle"></i>{{ $feature }}</li>
              @endforeach
              @if($offer->delivery_time)
                <li><i class="fas fa-check-circle"></i>{{ $offer->delivery_time }} Delivery</li>
              @endif
            </ul>
            @if($offer->exists)
              <a href="{{ $isFeatured ? route('website.checkout', $offer->slug) : route('website.offers.show', $offer->slug) }}" class="tcw-offer-card-btn {{ $isFeatured ? 'is-hot' : '' }}">
                {{ $isFeatured ? 'Get Started' : 'View Details' }}
              </a>
            @else
              <a href="{{ route('login') }}" class="tcw-offer-card-btn">View Details</a>
            @endif
          </article>
        @endforeach
      </div>

      <div class="tcw-offers-benefits">
        <article>
          <i class="fas fa-shield-alt"></i>
          <div><h4>100% Satisfaction</h4><p>We guarantee high-quality work and client satisfaction.</p></div>
        </article>
        <article>
          <i class="far fa-clock"></i>
          <div><h4>On Time Delivery</h4><p>We value your time and always deliver on time.</p></div>
        </article>
        <article>
          <i class="fas fa-lock"></i>
          <div><h4>Secure Payments</h4><p>Your payments are safe with our secure gateways.</p></div>
        </article>
        <article>
          <i class="fas fa-headset"></i>
          <div><h4>24/7 Support</h4><p>Our team is always here to support you.</p></div>
        </article>
      </div>

      <div class="tcw-offers-custom-cta">
        <div>
          <h3>Can't find what you need?</h3>
          <p>Let's discuss your custom project.</p>
        </div>
        <a href="{{ route('website.contact') }}">Request Custom Quote <i class="fas fa-arrow-right"></i></a>
      </div>
    </div>
  </section>
</main>
@endsection

@push('js')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const filters = document.querySelectorAll('.tcw-offers-filters [data-offer-category]');
    const cards = document.querySelectorAll('[data-offer-card]');

    if (!filters.length || !cards.length) return;

    const normalize = (value) => String(value || '').trim().toLowerCase();

    filters.forEach((filter) => {
      filter.addEventListener('click', function (event) {
        event.preventDefault();

        const selected = normalize(this.dataset.offerCategory);
        filters.forEach((item) => item.classList.toggle('is-active', item === this));

        cards.forEach((card) => {
          const category = normalize(card.dataset.offerCategory);
          const shouldShow = selected === 'all offers' || category === selected;
          card.classList.toggle('is-hidden', !shouldShow);
        });
      });
    });
  });
</script>
@endpush
