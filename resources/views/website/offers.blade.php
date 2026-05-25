@extends('layouts.website')

@section('title', __('website.offers.title'))
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

  $categories = collect([__('website.offers.all')])
      ->merge($offers->pluck('category')->filter()->unique()->values())
      ->when(!$offers->pluck('category')->contains('Design'), fn ($items) => $items->push('Design'))
      ->when(!$offers->pluck('category')->contains('SaaS Solutions'), fn ($items) => $items->push('SaaS Solutions'))
      ->values();
  $benefitIcons = ['fas fa-shield-alt', 'far fa-clock', 'fas fa-lock', 'fas fa-headset'];
@endphp

<main class="tcw-saas-page tcw-offers-page">
  <section class="tcw-offers-hero">
    <div class="container">
      <div class="tcw-offers-hero-grid">
        <div class="tcw-offers-hero-copy">
          <h1>{{ __('website.offers.heading') }} <span>{{ __('website.offers.highlight') }}</span></h1>
          <p class="tcw-offers-lead">{{ __('website.offers.lead') }}</p>
          <p>{{ __('website.offers.intro') }}</p>
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
        <div class="tcw-offers-filters" aria-label="{{ __('website.offers.categories') }}">
          @foreach($categories as $category)
            <a href="#offers" class="{{ $loop->first ? 'is-active' : '' }}" data-offer-category="{{ $loop->first ? '*' : $category }}">{{ $category }}</a>
          @endforeach
        </div>
        <div class="tcw-billing-toggle" aria-label="{{ __('website.offers.billing') }}">
          <span>{{ __('website.offers.monthly') }}</span>
          <b>{{ __('website.offers.one_time') }}</b>
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
            <h3>{{ $offer->localized('title') }}</h3>
            <p>{{ $offer->localized('description') }}</p>
            <div class="tcw-offer-price">
              <strong>{{ $offer->price_label }}</strong>
              @if(!empty($meta['old_price']))
                <small>{{ $meta['old_price'] }}</small>
              @endif
            </div>
            <ul>
              @foreach(array_slice($offer->localized('features') ?? [], 0, 6) as $feature)
                <li><i class="fas fa-check-circle"></i>{{ $feature }}</li>
              @endforeach
              @if($offer->delivery_time)
                <li><i class="fas fa-check-circle"></i>{{ $offer->delivery_time }} {{ __('website.offers.delivery') }}</li>
              @endif
            </ul>
            @if($offer->exists)
              <a href="{{ $isFeatured ? route('website.checkout', $offer->slug) : route('website.offers.show', $offer->slug) }}" class="tcw-offer-card-btn {{ $isFeatured ? 'is-hot' : '' }}">
                {{ $isFeatured ? __('website.common.get_started') : __('website.common.view_details') }}
              </a>
            @else
              <a href="{{ route('login') }}" class="tcw-offer-card-btn">{{ __('website.common.view_details') }}</a>
            @endif
          </article>
        @endforeach
      </div>

      <div class="tcw-offers-benefits">
        @foreach(__('website.offers.benefits') as $benefit)
          <article>
            <i class="{{ $benefitIcons[$loop->index] }}"></i>
            <div><h4>{{ $benefit['title'] }}</h4><p>{{ $benefit['text'] }}</p></div>
          </article>
        @endforeach
      </div>

      <div class="tcw-offers-custom-cta">
        <div>
          <h3>{{ __('website.offers.custom_title') }}</h3>
          <p>{{ __('website.offers.custom_text') }}</p>
        </div>
        <a href="{{ route('website.contact') }}">{{ __('website.offers.custom_button') }} <i class="fas fa-arrow-right"></i></a>
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
          const shouldShow = selected === '*' || category === selected;
          card.classList.toggle('is-hidden', !shouldShow);
        });
      });
    });
  });
</script>
@endpush
