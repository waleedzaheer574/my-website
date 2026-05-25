@extends('layouts.website')

@section('hide_global_faqs', '1')

@section('content')
<main class="tcw-about-page">
  <!-- Start Hero -->
  <div class="cs-hero cs-style8 cs-type1 cs-center text-center tcw-about-hero">
    <div class="container">
      <div class="cs-hero_text wow fadeInUp" data-wow-duration="1s" data-wow-delay="0.2s">
        <h1 class="cs-hero_title"><b class="cs-accent_color">About</b> Us</h1>
        <a href="#service" class="cs-down_btn cs-accent_color cs-accent_color_2_hover cs-smoth_scroll"><i class="fas fa-angle-down"></i></a>
      </div>
    </div>
    <div class="cs-hero_blur_shape">
      <div><img src="{{ asset('website/assets/img/design-agency/hero-blur-shape.png') }}" alt="" width="720" height="720" loading="lazy" decoding="async"></div>
    </div>
  </div>
  <!-- End Hero -->

  <!-- Start Dynamic Services -->
  <div id="service" class="cs-bg tcw-about-services-section">
    <div class="cs-height_140 cs-height_lg_80"></div>
    <div class="container wow fadeIn" data-wow-duration="1s" data-wow-delay="0.2s">
      <div class="cs-section_heading cs-style2 cs-size2">
        <div class="cs-section_subtitle">Our awesome services</div>
        <h2 class="cs-section_title">Our best services will make <br>
          your <b class="cs-accent_color cs-with_bar">
            business
            <svg width="208" height="11" viewBox="0 0 208 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="cs-accent_color_2">
              <path d="M8.90002 10.1C72.2 10.6 135.6 10.7 198.9 10.5C200.8 10.5 200.8 7.49998 198.9 7.49998C135.6 7.79998 72.2 7.69998 8.90002 7.09998C6.90002 7.09998 6.90002 10.1 8.90002 10.1Z" fill="currentColor"/>
              <path d="M1.90002 3.79999C69.9 3.79999 137.9 4.09999 205.9 4.89999C207.8 4.89999 207.8 1.89999 205.9 1.89999C137.9 1.19999 69.9 0.799988 1.90002 0.799988C-0.0999756 0.799988 -0.0999756 3.79999 1.90002 3.79999Z" fill="currentColor"/>
            </svg>
          </b> easy</h2>
      </div>
      <div class="cs-height_70 cs-height_lg_50"></div>
    </div>

    <div class="container wow fadeIn" data-wow-duration="1s" data-wow-delay="0.3s">
      <div class="row cs-gap_60 tcw-about-services-grid" data-load-more-grid data-load-more-step="6">
        @forelse($services as $service)
          @php
            $serviceUrl = $service->detail
                ? route('website.service-details.show', $service->detail->slug)
                : route('website.services');
          @endphp
          <div class="col-lg-4 tcw-about-service-col tcw-load-more-item {{ $loop->index >= 6 ? 'is-hidden' : '' }}" data-load-more-item>
            <a href="{{ $serviceUrl }}" class="cs-icon_box cs-style6 cs-transition_3">
              <div class="cs-icon_box_in">
                <div class="cs-icon_box_icon cs-center cs-transition_4" data-src="{{ asset('website/assets/img/design-agency/iconbox-shape1.svg') }}">
                  @if($service->icon)
                    <img src="{{ asset($service->icon) }}" alt="{{ $service->service_title }}" class="tcw-icon-img-48" width="48" height="48" loading="lazy" decoding="async">
                  @else
                    <i class="fas fa-briefcase tcw-icon-fallback-white-lg"></i>
                  @endif
                </div>
                <h2 class="cs-icon_box_title cs-semi_bold cs-transition_3">{{ $service->service_title }}</h2>
                <div class="cs-icon_box_subtitle cs-transition_3">{{ \Illuminate\Support\Str::limit($service->service_description ?? '', 135) }}</div>
              </div>
              <div class="cs-icon_box_shape cs-accent_color">
                <svg class="cs-transition_3" xmlns="http://www.w3.org/2000/svg" opacity="0.051" width="247px" height="257px">
                  <path fill-rule="evenodd" fill="currentColor" d="M0.717,256.609 C0.717,256.609 7.824,164.313 102.262,127.457 C196.699,90.601 230.049,0.643 230.049,0.643 L246.891,241.481 L0.717,256.609 Z"/>
                </svg>
              </div>
            </a>
            <div class="cs-height_30 cs-height_lg_30"></div>
          </div>
        @empty
          <div class="col-12">
            <div class="cs-section_text">Services will appear here after you add them from the dashboard.</div>
          </div>
        @endforelse
      </div>

      @if($services->count() > 6)
        <div class="tcw-load-more-wrap wow fadeInUp" data-wow-duration="0.9s" data-wow-delay="0.1s">
          <button type="button" class="tcw-load-more-btn" data-load-more-btn>
            <i class="fas fa-sync-alt"></i> Load More
          </button>
        </div>
      @endif
    </div>
    <div class="cs-height_110 cs-height_lg_50"></div>
  </div>
  <!-- End Dynamic Services -->

  <!-- Start Dynamic Portfolio item -->
  <div class="cs-height_140 cs-height_lg_80"></div>
  <div class="container wow fadeIn tcw-about-portfolio-section" data-wow-duration="1s" data-wow-delay="0.2s">
    <div class="row">
      <div class="col-lg-6">
        <div class="cs-section_heading cs-style2 cs-size2">
          <div class="cs-section_subtitle">Our portfolio</div>
          <h2 class="cs-section_title">Our Featured <br><b class="cs-extra_bold cs-accent_color cs-with_bar">
            Portfolio
            <svg width="208" height="11" viewBox="0 0 208 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="cs-accent_color_2">
              <path d="M8.90002 10.1C72.2 10.6 135.6 10.7 198.9 10.5C200.8 10.5 200.8 7.49998 198.9 7.49998C135.6 7.79998 72.2 7.69998 8.90002 7.09998C6.90002 7.09998 6.90002 10.1 8.90002 10.1Z" fill="currentColor"/>
              <path d="M1.90002 3.79999C69.9 3.79999 137.9 4.09999 205.9 4.89999C207.8 4.89999 207.8 1.89999 205.9 1.89999C137.9 1.19999 69.9 0.799988 1.90002 0.799988C-0.0999756 0.799988 -0.0999756 3.79999 1.90002 3.79999Z" fill="currentColor"/>
            </svg>
          </b></h2>
          <div class="cs-section_text">Explore our latest client work and digital projects.</div>
          <div class="cs-height_30 cs-height_lg_30"></div>
          <a href="{{ route('website.portfolio') }}" class="cs-btn cs-style6 cs-btn_lg cs-rounded text-uppercase cs-medium cs-accent_border cs-accent_bg cs-white cs-accent_10_bg_hover cs-accent_40_border_hover">
            <span class="cs-btn_text">View All</span>
          </a>
        </div>
        <div class="cs-height_0 cs-height_lg_50"></div>
      </div>
      <div class="col-lg-6">
        <div class="cs-right_full_width">
            <div class="cs-slider cs-style2 cs-gap-40 tcw-about-portfolio-slider">
              <div class="cs-slider_container" data-autoplay="3000" data-loop="1" data-speed="700" data-center="0" data-fade-slide="0" data-slides-per-view="1" data-variable-width="0">
              <div class="cs-slider_wrapper">
                @forelse($aboutPortfolios as $portfolio)
                  <div class="cs-slide">
                    <a href="{{ route('website.portfolio-details.show', $portfolio->slug) }}" class="cs-portfolio cs-style3">
                      <div class="cs-portfolio_img">
                        <img src="{{ asset($portfolio->image ?: 'website/assets/img/generated/home-hero-optimized.jpg') }}" alt="{{ $portfolio->title }}" width="560" height="380" loading="lazy" decoding="async">
                      </div>
                      <h2 class="cs-portfolio_title">{{ $portfolio->title }}</h2>
                    </a>
                  </div>
                @empty
                  <div class="cs-slide">
                    <a href="{{ route('website.portfolio') }}" class="cs-portfolio cs-style3">
                      <div class="cs-portfolio_img">
                        <img src="{{ asset('website/assets/img/generated/home-hero-optimized.jpg') }}" alt="Portfolio" width="560" height="380" loading="lazy" decoding="async">
                      </div>
                      <h2 class="cs-portfolio_title">Portfolio coming soon</h2>
                    </a>
                  </div>
                @endforelse
              </div>
            </div>
            </div>
        </div>
      </div>
    </div>
  </div>
  <div class="cs-height_140 cs-height_lg_80"></div>
  <!-- End Dynamic Portfolio item -->

  @include('partials.website.review-slider', ['reviews' => $reviews])

  <!-- Start CTA -->
  <div class="cs-height_30 cs-height_lg_0"></div>
  <div class="cs-cta cs-style5 cs-bg" data-src="{{ asset('website/assets/img/generated/home-hero-optimized.jpg') }}">
    <div class="container wow fadeIn" data-wow-duration="1s" data-wow-delay="0.3s">
      <div class="row">
        <div class="col-lg-6">
          <div class="cs-left_full_width text-center">
            <div class="cs-cta_img"><img src="{{ asset('website/assets/img/design-agency/cta-img.png') }}" alt="" width="500" height="500" loading="lazy" decoding="async"></div>
          </div>
        </div>
        <div class="col-xl-5 offset-xl-1 col-lg-6">
          <div class="cs-vertical_middle">
            <div class="cs-cta_info">
              <h2 class="cs-cta_title">Have a project? <b class="cs-accent_color cs-with_bar">
                Let's talk
                <svg width="208" height="11" viewBox="0 0 208 11" fill="none" xmlns="http://www.w3.org/2000/svg" class="cs-accent_color_2">
                  <path d="M8.90002 10.1C72.2 10.6 135.6 10.7 198.9 10.5C200.8 10.5 200.8 7.49998 198.9 7.49998C135.6 7.79998 72.2 7.69998 8.90002 7.09998C6.90002 7.09998 6.90002 10.1 8.90002 10.1Z" fill="currentColor"/>
                  <path d="M1.90002 3.79999C69.9 3.79999 137.9 4.09999 205.9 4.89999C207.8 4.89999 207.8 1.89999 205.9 1.89999C137.9 1.19999 69.9 0.799988 1.90002 0.799988C-0.0999756 0.799988 -0.0999756 3.79999 1.90002 3.79999Z" fill="currentColor"/>
                </svg>
              </b></h2>
              <div class="cs-cta_subtitle">Tell us about your next idea and we will help you plan the right next step.</div>
              <div class="cs-cta_btns">
                <a href="{{ url('/contact') }}" class="cs-btn cs-style6 cs-btn_lg cs-rounded text-uppercase cs-medium cs-accent_border cs-accent_bg cs-white cs-accent_10_bg_hover cs-accent_40_border_hover">
                  <span class="cs-btn_text">Contact Us</span>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- End CTA -->

  @include('partials.website.faqs')
</main>
@endsection
