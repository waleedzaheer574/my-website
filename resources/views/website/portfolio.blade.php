@extends('layouts.website')

@section('content')
  <!-- Start Hero -->
  <div class="cs-hero cs-style8 cs-type1 cs-center text-center" data-src="{{ asset('website/assets/img/design-agency/icon-box-bg2.jpg') }}">
    <div class="container">
      <div class="cs-hero_text">
        <h1 class="cs-hero_title"><b class="cs-accent_color">{{ __('website.portfolio.title') }}</b></h1>
        <a href="#next_section" class="cs-down_btn cs-accent_color cs-accent_color_2_hover cs-smoth_scroll"><i class="fas fa-angle-down"></i></a>
      </div>
    </div>
    <div class="cs-hero_blur_shape">
      <div class=""><img src="{{ asset('website/assets/img/design-agency/hero-blur-shape.png') }}" alt="" width="720" height="720" loading="lazy" decoding="async"></div>
    </div>
  </div>
  <!-- End Hero -->

  <!-- Start Portfolio -->
  <div id="next_section" class="tcw-portfolio-listing">
    <div class="cs-height_140 cs-height_lg_80"></div>
    <div class="container">
      <div class="row" data-load-more-grid data-load-more-step="6">
        @forelse($portfolios as $portfolio)
          <div class="col-lg-6 {{ $loop->index >= 6 ? 'tcw-load-more-item is-hidden' : 'tcw-load-more-item' }}" data-load-more-item>
            <a href="{{ route('website.portfolio-details.show', $portfolio->slug) }}" class="cs-portfolio cs-style3 cs-type1">
              <div class="cs-portfolio_img">
                <img src="{{ asset($portfolio->image) }}" alt="{{ $portfolio->localized('title') }}" width="720" height="480" loading="lazy" decoding="async">
              </div>
              <h2 class="cs-portfolio_title">{{ $portfolio->localized('title') }}</h2>
            </a>
            <div class="cs-height_30 cs-height_lg_30"></div>
          </div>
        @empty
          <div class="col-12">
            <div class="cs-post cs-style8">
              <div class="cs-post_right">
                <h2 class="cs-post_title">{{ __('website.portfolio.empty') }}</h2>
              </div>
            </div>
          </div>
        @endforelse
      </div>

      @if($portfolios->count() > 6)
        <div class="tcw-load-more-wrap">
          <button type="button" class="tcw-load-more-btn" data-load-more-button>
            <i class="fas fa-sync-alt"></i> {{ __('website.common.load_more') }}
          </button>
        </div>
      @endif
    </div>
    <div class="cs-height_110 cs-height_lg_50"></div>
  </div>
  <!-- End Portfolio -->
@endsection
