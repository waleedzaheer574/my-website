@extends('layouts.website')

@section('title', 'Services')

@section('content')
  <div class="cs-hero cs-style8 cs-type1 cs-center text-center" data-src="{{ asset('website/assets/img/design-agency/icon-box-bg2.jpg') }}">
    <div class="container">
      <div class="cs-hero_text">
        <h1 class="cs-hero_title">All <b class="cs-accent_color">Services</b></h1>
        <a href="#service-list" class="cs-down_btn cs-accent_color cs-accent_color_2_hover cs-smoth_scroll"><i class="fas fa-angle-down"></i></a>
      </div>
    </div>
    <div class="cs-hero_blur_shape">
      <div><img src="{{ asset('website/assets/img/design-agency/hero-blur-shape.png') }}" alt="" width="720" height="720" loading="lazy" decoding="async"></div>
    </div>
  </div>

  <section id="service-list" class="cs-bg tcw-services-page-section">
    <div class="cs-height_140 cs-height_lg_80"></div>
    <div class="container">
      @if($services->isEmpty())
        <div class="text-center tcw-empty-state">
          <h2 class="tcw-empty-title">No services available yet</h2>
          <p class="tcw-empty-text">Admin panel se services add karne ke baad ye section automatically populate ho jayega.</p>
        </div>
      @else
        <div class="row tcw-home-services-grid" data-load-more-grid data-load-more-step="6">
          @foreach($services as $service)
            @php
              $serviceUrl = $service->detail
                ? route('website.service-details.show', $service->detail->slug)
                : route('website.services');
            @endphp
            <div class="col-lg-4 col-md-6 {{ $loop->index >= 6 ? 'tcw-load-more-item is-hidden' : 'tcw-load-more-item' }}" data-load-more-item>
              <a href="{{ $serviceUrl }}" class="cs-icon_box cs-style6 cs-transition_3 tcw-feature-card tcw-feature-card-alt tcw-full-height">
                <div class="cs-icon_box_in">
                  <div class="cs-icon_box_icon cs-center cs-transition_4 tcw-home-service-icon">
                    @if($service->icon)
                      <img src="{{ asset($service->icon) }}" alt="{{ $service->service_title }}" width="56" height="56" loading="lazy" decoding="async">
                    @else
                      <i class="fas fa-briefcase tcw-icon-fallback-accent"></i>
                    @endif
                  </div>
                  <h2 class="cs-icon_box_title cs-semi_bold cs-transition_3">{{ $service->service_title }}</h2>
                  <div class="cs-icon_box_subtitle cs-transition_3">
                    {{ \Illuminate\Support\Str::limit($service->service_description, 140) }}
                  </div>
                </div>
              </a>
              <div class="cs-height_50 cs-height_lg_30"></div>
            </div>
          @endforeach
        </div>

        @if($services->count() > 6)
          <div class="tcw-load-more-wrap">
            <button type="button" class="tcw-load-more-btn" data-load-more-button>
              <i class="fas fa-sync-alt"></i> Load More
            </button>
          </div>
        @endif
      @endif
    </div>
    <div class="cs-height_60 cs-height_lg_40"></div>
  </section>
@endsection
