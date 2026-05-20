@php
  $companySetting = $websiteCompanySetting ?? null;
  $websiteLogo = $companySetting?->logo
    ? asset('storage/' . $companySetting->logo) . '?v=' . optional($companySetting->updated_at)->timestamp
    : asset('website/assets/img/design-agency/logo.svg');
  $websiteLogoAlt = $companySetting?->email ?: 'Multitechwave';
  $servicesMenuItems = ($websiteServices ?? collect())->take(6);
  $isAbout = request()->is('about');
  $isService = request()->is('service') || request()->is('service-details') || request()->is('service*');
  $isIndustries = request()->is('industries');
  $isPortfolio = request()->is('portfolio') || request()->is('portfolio-details') || request()->is('portfolio*');
  $isCaseStudies = request()->is('case-studies');
  $isTestimonials = request()->is('testimonials');
  $isBlog = request()->is('blog') || request()->is('blog-details') || request()->is('blog*');
  $isQuote = request()->is('quote-generator*');
  $isOffers = request()->is('offers*') || request()->is('checkout*');
  $isHome = request()->is('/');
@endphp


<!-- Start Preloader -->
<div class="cs-preloader cs-accent_color cs-white_bg">
  <div class="cs-preloader_bg cs-center cs-accent_4_bg">
    <div class="cs-preloader_in cs-accent_15_border">
      <img src="{{ $websiteLogo }}" alt="{{ $websiteLogoAlt }}" width="220" height="78" decoding="async">
    </div>
  </div>
</div>
<!-- End Preloader -->

<!-- Start Header Section -->
<header class="cs-site_header cs-style1 cs-type3 cs-sticky-header tcw-site-header">
  <div class="cs-main_header">
    <div class="cs-main_header_in tcw-header_shell">
      <div class="cs-main_header_left">
        <a class="cs-site_branding tcw-brand" href="{{ url('/') }}" aria-label="Multitechwave home">
          <img src="{{ $websiteLogo }}" alt="{{ $websiteLogoAlt }}" width="220" height="78" decoding="async">
        </a>
      </div>

      <div class="cs-main_header_center">
        <nav class="tcw-nav" aria-label="Primary navigation">
          <ul class="tcw-nav_list">
            <li class="tcw-nav_item {{ $isHome ? 'is-active' : '' }}">
              <a href="{{ url('/') }}">Home</a>
            </li>
            <li class="tcw-nav_item {{ $isAbout ? 'is-active' : '' }}">
              <a href="{{ url('/about') }}">About Us</a>
            </li>
            <li class="tcw-nav_item tcw-has_dropdown {{ $isService ? 'is-active' : '' }}">
              <span class="tcw-dropdown_link_group">
                <a href="{{ route('website.services') }}">Services</a>
                <button class="tcw-dropdown_toggle" type="button" aria-expanded="false" aria-controls="tcw-services-dropdown" aria-label="Toggle services dropdown">
                  <i class="fas fa-chevron-down"></i>
                </button>
              </span>
              <div class="tcw-mega_panel" id="tcw-services-dropdown">
                <div class="tcw-services_list" role="list">
                  @foreach ($servicesMenuItems as $service)
                    <a href="{{ $service->detail ? route('website.service-details.show', $service->detail->slug) : route('website.services') }}" class="tcw-service_item" role="listitem">
                      <span class="tcw-service_icon">
                        @if($service->icon)
                          <img src="{{ asset($service->icon) }}" alt="{{ $service->service_title }}" width="48" height="48" loading="lazy" decoding="async">
                        @else
                          <i class="fas fa-briefcase"></i>
                        @endif
                      </span>
                      <span class="tcw-service_content">
                        <span class="tcw-service_title">{{ $service->service_title }}</span>
                        <span class="tcw-service_text">{{ \Illuminate\Support\Str::limit($service->service_description, 90) }}</span>
                      </span>
                      <span class="tcw-service_arrow"><i class="fas fa-arrow-right"></i></span>
                    </a>
                  @endforeach
                </div>
              </div>
            </li>
            <li class="tcw-nav_item {{ $isPortfolio ? 'is-active' : '' }}">
              <a href="{{ url('/portfolio') }}">Portfolio</a>
            </li>
            <li class="tcw-nav_item {{ $isOffers ? 'is-active' : '' }}">
              <a href="{{ route('website.offers') }}">Offers</a>
            </li>
            <li class="tcw-nav_item {{ $isIndustries ? 'is-active' : '' }}">
              <a href="{{ route('website.industries') }}">Industries</a>
            </li>
            <li class="tcw-nav_item {{ $isTestimonials ? 'is-active' : '' }}">
              <a href="{{ route('website.testimonials') }}">Testimonials</a>
            </li>
            <li class="tcw-nav_item {{ $isBlog ? 'is-active' : '' }}">
              <a href="{{ url('/blog') }}">Blog</a>
            </li>
            <li class="tcw-nav_item {{ $isQuote ? 'is-active' : '' }}">
              <a href="{{ route('website.quote-generator') }}">Quote</a>
            </li>
          </ul>
        </nav>
      </div>

      <div class="cs-main_header_right">
        <div class="tcw-header_actions">
          @auth
            <a href="{{ auth()->user()->isAdmin() ? route('dashboard') : route('user.dashboard') }}" class="tcw-header_auth" aria-label="Dashboard" title="Dashboard">
              <i class="fas fa-user"></i>
            </a>
          @else
            <a href="{{ route('login') }}" class="tcw-header_auth" aria-label="Login" title="Login">
              <i class="fas fa-user"></i>
            </a>
          @endauth
          <a href="{{ url('/contact') }}" class="tcw-header_cta">Contact Us</a>
        </div>

        <button class="tcw-menu_toggle" type="button" aria-expanded="false" aria-controls="tcw-mobile-nav" aria-label="Open navigation">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
    </div>

    <div class="tcw-mobile_panel" id="tcw-mobile-nav" hidden>
      <div class="tcw-mobile_panel_inner">
        <a href="{{ url('/') }}" class="tcw-mobile_link {{ $isHome ? 'is-active' : '' }}">Home</a>
        <a href="{{ url('/about') }}" class="tcw-mobile_link {{ $isAbout ? 'is-active' : '' }}">About Us</a>

        <div class="tcw-mobile_group {{ $isService ? 'is-open' : '' }}">
          <button class="tcw-mobile_group_toggle" type="button" aria-expanded="{{ $isService ? 'true' : 'false' }}">
            <span>Services</span>
            <i class="fas fa-plus"></i>
          </button>
          <div class="tcw-mobile_group_body" @unless($isService) hidden @endunless>
            @foreach ($servicesMenuItems as $service)
              <a href="{{ $service->detail ? route('website.service-details.show', $service->detail->slug) : route('website.services') }}" class="tcw-mobile_sublink">
                <span class="tcw-mobile_sublink_icon">
                  @if($service->icon)
                    <img src="{{ asset($service->icon) }}" alt="{{ $service->service_title }}" width="42" height="42" loading="lazy" decoding="async">
                  @else
                    <i class="fas fa-briefcase"></i>
                  @endif
                </span>
              <span class="tcw-mobile_sublink_content">
                <span class="tcw-mobile_sublink_title">{{ $service->service_title }}</span>
                <span class="tcw-mobile_sublink_text">{{ \Illuminate\Support\Str::limit($service->service_description, 80) }}</span>
              </span>
            </a>
          @endforeach
        </div>
        </div>

        <a href="{{ url('/portfolio') }}" class="tcw-mobile_link {{ $isPortfolio ? 'is-active' : '' }}">Portfolio</a>
        <a href="{{ route('website.offers') }}" class="tcw-mobile_link {{ $isOffers ? 'is-active' : '' }}">Offers</a>
        <a href="{{ route('website.industries') }}" class="tcw-mobile_link {{ $isIndustries ? 'is-active' : '' }}">Industries</a>
        <a href="{{ route('website.testimonials') }}" class="tcw-mobile_link {{ $isTestimonials ? 'is-active' : '' }}">Testimonials</a>
        <a href="{{ url('/blog') }}" class="tcw-mobile_link {{ $isBlog ? 'is-active' : '' }}">Blog</a>
        <a href="{{ route('website.quote-generator') }}" class="tcw-mobile_link {{ $isQuote ? 'is-active' : '' }}">Quote Generator</a>
        @auth
          <a href="{{ auth()->user()->isAdmin() ? route('dashboard') : route('user.dashboard') }}" class="tcw-mobile_link">My Dashboard</a>
          <form action="{{ route('logout') }}" method="POST" class="tcw-mobile_auth_form">
            @csrf
            <button type="submit">Logout</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="tcw-mobile_link">Login</a>
        @endauth
        <div class="tcw-mobile_cta_wrap">
          <p>Have a project in mind? Let us shape the right launch plan.</p>
          <a href="{{ url('/contact') }}" class="tcw-header_cta tcw-header_cta_full">Start a Project</a>
        </div>
      </div>
    </div>
  </div>
</header>
<!-- End Header Section -->
