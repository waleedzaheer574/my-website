@extends('layouts.website')

@section('content')
  <main class="tcw-dimensional-page tcw-industries-page">
    <section class="tcw-dimensional-hero">
      <div class="container">
        <div class="tcw-dimensional-hero-grid">
          <div class="tcw-dimensional-hero-copy wow fadeInUp" data-wow-duration="1s">
            <span class="tcw-detail-eyebrow">{{ __('website.industries.label') }}</span>
            <h1>{{ __('website.industries.heading') }} <span>{{ __('website.industries.highlight') }}</span></h1>
            <p>{{ __('website.industries.intro') }}</p>
            <a href="#page-content" class="tcw-it-btn tcw-it-btn-primary cs-smoth_scroll">
              {{ __('website.industries.explore') }} <i class="fas fa-arrow-down"></i>
            </a>
          </div>

          <div class="tcw-dimensional-hero-stage wow fadeIn" data-wow-duration="1s" data-wow-delay="0.15s" aria-hidden="true">
            <div class="tcw-orbit-card tcw-orbit-card-1">
              <i class="fas fa-chart-line"></i>
              <span>Growth</span>
            </div>
            <div class="tcw-orbit-card tcw-orbit-card-2">
              <i class="fas fa-layer-group"></i>
              <span>UX Systems</span>
            </div>
            <div class="tcw-orbit-card tcw-orbit-card-3">
              <i class="fas fa-bolt"></i>
              <span>Automation</span>
            </div>
            <div class="tcw-dimensional-core">
              <span>4D</span>
              <strong>Sector UI</strong>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="page-content" class="tcw-dimensional-section">
      <div class="container">
        <div class="tcw-detail-heading text-center wow fadeInUp" data-wow-duration="1s">
          <span class="tcw-detail-eyebrow">{{ __('website.industries.solutions') }}</span>
          <h2>{{ __('website.industries.section_heading') }} <span>{{ __('website.industries.section_highlight') }}</span></h2>
        </div>

        <div class="tcw-dimensional-grid tcw-industry-grid" data-load-more-grid data-load-more-step="6">
          @forelse ($industries as $industry)
            @php
              $industryIconMap = [
                'real estate' => 'fas fa-building',
                'healthcare' => 'fas fa-heartbeat',
                'e-commerce' => 'fas fa-shopping-cart',
                'education' => 'fas fa-graduation-cap',
                'finance' => 'fas fa-wallet',
                'hospitality' => 'fas fa-concierge-bell',
                'automotive' => 'fas fa-car',
                'legal services' => 'fas fa-balance-scale',
                'construction' => 'fas fa-hard-hat',
                'fitness & wellness' => 'fas fa-dumbbell',
              ];
              $industryIconClass = $industryIconMap[strtolower($industry->title)] ?? 'fas fa-briefcase';
            @endphp
            <article class="tcw-dimensional-card tcw-industry-4d-card wow fadeInUp {{ $loop->index >= 6 ? 'tcw-load-more-item is-hidden' : 'tcw-load-more-item' }}" data-load-more-item data-wow-duration="1s" data-wow-delay="{{ number_format($loop->index * 0.05, 2) }}s">
              <div class="tcw-dimensional-card-glow"></div>
              <div class="tcw-industry-card-top">
                <div class="tcw-industry-icon">
                  @if($industry->icon)
                    <img src="{{ asset($industry->icon) }}" alt="{{ $industry->localized('title') }}" loading="lazy" decoding="async">
                  @else
                    <i class="{{ $industryIconClass }}"></i>
                  @endif
                </div>
                <span>{{ $industry->localized('category') ?: __('website.industries.label') }}</span>
              </div>

              <div class="tcw-industry-card-body">
                @if($industry->localized('result'))
                  <strong>{{ $industry->localized('result') }}</strong>
                @endif
                <h3>{{ $industry->localized('title') }}</h3>
                <p>{{ $industry->localized('description') }}</p>
              </div>

              <a href="{{ $industry->cta_url ?: url('/contact') }}" class="tcw-dimensional-link">
                {{ __('website.industries.discuss') }} <i class="fas fa-arrow-right"></i>
              </a>
            </article>
          @empty
            <div class="tcw-dimensional-empty">
              {{ __('website.industries.empty') }}
            </div>
          @endforelse
        </div>

        @if($industries->count() > 6)
          <div class="tcw-load-more-wrap">
            <button type="button" class="tcw-load-more-btn" data-load-more-button>
              <i class="fas fa-sync-alt"></i> {{ __('website.common.load_more') }}
            </button>
          </div>
        @endif
      </div>
    </section>
  </main>
@endsection
