@extends('layouts.website')

@section('content')
  <main class="tcw-dimensional-page tcw-testimonials-page">
    <section class="tcw-dimensional-hero">
      <div class="container">
        <div class="tcw-dimensional-hero-grid">
          <div class="tcw-dimensional-hero-copy wow fadeInUp" data-wow-duration="1s">
            <span class="tcw-detail-eyebrow">Testimonials</span>
            <h1>Client stories with <span>proof, ratings, and trust</span></h1>
            <p>Every card below is powered by the client reviews you manage from the dashboard.</p>
            <a href="#page-content" class="tcw-it-btn tcw-it-btn-primary cs-smoth_scroll">
              View Feedback <i class="fas fa-arrow-down"></i>
            </a>
          </div>

          <div class="tcw-dimensional-hero-stage wow fadeIn" data-wow-duration="1s" data-wow-delay="0.15s" aria-hidden="true">
            <div class="tcw-orbit-card tcw-orbit-card-1">
              <i class="fas fa-star"></i>
              <span>Ratings</span>
            </div>
            <div class="tcw-orbit-card tcw-orbit-card-2">
              <i class="fas fa-quote-left"></i>
              <span>Feedback</span>
            </div>
            <div class="tcw-orbit-card tcw-orbit-card-3">
              <i class="fas fa-user-check"></i>
              <span>Trust</span>
            </div>
            <div class="tcw-dimensional-core">
              <span>{{ $reviews->count() }}</span>
              <strong>Reviews</strong>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section id="page-content" class="tcw-dimensional-section">
      <div class="container">
        <div class="tcw-detail-heading text-center wow fadeInUp" data-wow-duration="1s">
          <span class="tcw-detail-eyebrow">Clients feedback</span>
          <h2>What our <span>clients say</span></h2>
        </div>

        <div class="tcw-dimensional-grid tcw-testimonial-grid" data-load-more-grid data-load-more-step="6">
          @forelse($reviews as $review)
            @php
              $rating = max(1, min(5, (int) ($review->rating ?? 5)));
            @endphp
            <article class="tcw-dimensional-card tcw-testimonial-4d-card {{ $review->is_featured ? 'is-featured' : '' }} wow fadeInUp {{ $loop->index >= 6 ? 'tcw-load-more-item is-hidden' : 'tcw-load-more-item' }}" data-load-more-item data-wow-duration="1s" data-wow-delay="{{ number_format($loop->index * 0.05, 2) }}s">
              <div class="tcw-dimensional-card-glow"></div>
              <div class="tcw-testimonial-card-head">
                <div class="tcw-testimonial-avatar">{{ \Illuminate\Support\Str::of($review->client_name)->substr(0, 1)->upper() }}</div>
                <div>
                  <h3>{{ $review->client_name }}</h3>
                  @if($review->designation)
                    <span>{{ $review->designation }}</span>
                  @endif
                </div>
              </div>

              <div class="tcw-testimonial-rating" aria-label="{{ $rating }} out of 5 stars">
                @for($i = 1; $i <= 5; $i++)
                  <span class="{{ $i <= $rating ? 'is-filled' : '' }}" aria-hidden="true">&#9733;</span>
                @endfor
              </div>

              @if($review->badge)
                <div class="tcw-testimonial-badge">{{ $review->badge }}</div>
              @endif

              <p>{{ $review->review_text }}</p>
            </article>
          @empty
            <div class="tcw-dimensional-empty">
              Client reviews will appear here after you add active reviews from the dashboard.
            </div>
          @endforelse
        </div>

        @if($reviews->count() > 6)
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
