@extends('layouts.website')

@section('content')
  <main class="tcw-dimensional-page tcw-industries-page">
    <section class="tcw-dimensional-hero">
      <div class="container">
        <div class="tcw-dimensional-hero-grid">
          <div class="tcw-dimensional-hero-copy wow fadeInUp" data-wow-duration="1s">
            <span class="tcw-detail-eyebrow">Industries</span>
            <h1>Digital systems shaped for <span>real business sectors</span></h1>
            <p>Explore the industries managed from your dashboard and see how each offer, result, and call-to-action is presented on the public site.</p>
            <a href="#page-content" class="tcw-it-btn tcw-it-btn-primary cs-smoth_scroll">
              Explore Industries <i class="fas fa-arrow-down"></i>
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
          <span class="tcw-detail-eyebrow">Focused Solutions</span>
          <h2>Built for the needs of <span>modern businesses</span></h2>
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
                    <img src="{{ asset($industry->icon) }}" alt="{{ $industry->title }}" loading="lazy" decoding="async">
                  @else
                    <i class="{{ $industryIconClass }}"></i>
                  @endif
                </div>
                <span>{{ $industry->category ?: 'Industry' }}</span>
              </div>

              <div class="tcw-industry-card-body">
                @if($industry->result)
                  <strong>{{ $industry->result }}</strong>
                @endif
                <h3>{{ $industry->title }}</h3>
                <p>{{ $industry->description }}</p>
              </div>

              <a href="{{ $industry->cta_url ?: url('/contact') }}" class="tcw-dimensional-link">
                Discuss This Industry <i class="fas fa-arrow-right"></i>
              </a>
            </article>
          @empty
            <div class="tcw-dimensional-empty">
              Industries will appear here after you add them from the dashboard.
            </div>
          @endforelse
        </div>

        @if($industries->count() > 6)
          <div class="tcw-load-more-wrap">
            <button type="button" class="tcw-load-more-btn" data-load-more-button>
              <i class="fas fa-sync-alt"></i> Load More
            </button>
          </div>
        @endif
      </div>
    </section>
  </main>
@endsection
