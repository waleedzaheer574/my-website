<!-- Start Client Reviews -->
<section class="client-reviews tcw-reviews-section">
  <div class="cs-height_135 cs-height_lg_75"></div>
  <div class="container wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
    <div class="cs-section_heading cs-style2 cs-size2 text-center">
      <div class="cs-section_subtitle">{{ __('website.reviews.label') }}</div>
      <h2 class="cs-section_title cs-medium">{{ __('website.reviews.title_prefix') }} <b class="cs-accent_color cs-with_bar">
        {{ __('website.reviews.title_highlight') }}
        <svg width="208" height="11" viewBox="0 0 208 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="cs-accent_color_2">
          <path d="M8.90002 10.1C72.2 10.6 135.6 10.7 198.9 10.5C200.8 10.5 200.8 7.49998 198.9 7.49998C135.6 7.79998 72.2 7.69998 8.90002 7.09998C6.90002 7.09998 6.90002 10.1 8.90002 10.1Z" fill="currentColor"/>
          <path d="M1.90002 3.79999C69.9 3.79999 137.9 4.09999 205.9 4.89999C207.8 4.89999 207.8 1.89999 205.9 1.89999C137.9 1.19999 69.9 0.799988 1.90002 0.799988C-0.0999756 0.799988 -0.0999756 3.79999 1.90002 3.79999Z" fill="currentColor"/>
        </svg>
      </b></h2>
    </div>
    <div class="cs-height_90 cs-height_lg_50"></div>
  </div>

  <div class="tcw-review-stage wow fadeIn" data-wow-duration="1s" data-wow-delay="0.3s" data-review-rail>
    <div class="tcw-review-slider-wrap">
      <button class="tcw-review-arrow tcw-review-prev" type="button" aria-label="{{ __('website.reviews.previous') }}" data-review-prev>
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
      </button>
      <button class="tcw-review-arrow tcw-review-next" type="button" aria-label="{{ __('website.reviews.next') }}" data-review-next>
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
          <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
      </button>

      <div class="tcw-review-slider" data-review-track>
        @forelse($reviews as $review)
          @php
            $rating = max(1, min(5, (int) ($review->rating ?? 5)));
          @endphp
          <div class="tcw-review-slide">
            <article class="client-review-card tcw-dimensional-card tcw-testimonial-4d-card {{ $review->is_featured ? 'is-featured' : '' }}">
              <div class="tcw-dimensional-card-glow"></div>
              <div class="client-review-author tcw-testimonial-card-head">
                <div class="client-review-avatar tcw-testimonial-avatar">{{ \Illuminate\Support\Str::of($review->client_name)->substr(0, 1)->upper() }}</div>
                <div>
                  <h3>{{ $review->client_name }}</h3>
                  @if($review->localized('designation'))
                    <span class="client-review-role">{{ $review->localized('designation') }}</span>
                  @endif
                </div>
              </div>

              <div class="client-review-rating tcw-testimonial-rating" aria-label="{{ __('website.reviews.rating', ['rating' => $rating]) }}">
                @for($i = 1; $i <= 5; $i++)
                  <span class="{{ $i <= $rating ? 'is-filled' : '' }}" aria-hidden="true">&#9733;</span>
                @endfor
              </div>

              @if($review->localized('badge'))
                <div class="tcw-testimonial-badge client-review-badge">{{ $review->localized('badge') }}</div>
              @endif

              @if($review->localized('review_text'))
                <p>{{ $review->localized('review_text') }}</p>
              @endif
            </article>
          </div>
        @empty
          <div class="tcw-review-empty">
            {{ __('website.reviews.empty') }}
          </div>
        @endforelse
      </div>
    </div>
  </div>

  <div class="cs-height_140 cs-height_lg_80"></div>
</section>
<!-- End Client Reviews -->
