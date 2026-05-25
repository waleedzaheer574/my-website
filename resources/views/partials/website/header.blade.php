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
  $isArabic = app()->getLocale() === 'ar';
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
        <nav class="tcw-nav" aria-label="{{ __('website.nav.home') }}">
          <ul class="tcw-nav_list">
            <li class="tcw-nav_item {{ $isHome ? 'is-active' : '' }}">
              <a href="{{ url('/') }}">{{ __('website.nav.home') }}</a>
            </li>
            <li class="tcw-nav_item {{ $isAbout ? 'is-active' : '' }}">
              <a href="{{ url('/about') }}">{{ __('website.nav.about') }}</a>
            </li>
            <li class="tcw-nav_item tcw-has_dropdown {{ $isService ? 'is-active' : '' }}">
              <span class="tcw-dropdown_link_group">
                <a href="{{ route('website.services') }}">{{ __('website.nav.services') }}</a>
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
                          <img src="{{ asset($service->icon) }}" alt="{{ $service->localized('service_title') }}" width="48" height="48" loading="lazy" decoding="async">
                        @else
                          <i class="fas fa-briefcase"></i>
                        @endif
                      </span>
                      <span class="tcw-service_content">
                        <span class="tcw-service_title">{{ $service->localized('service_title') }}</span>
                        <span class="tcw-service_text">{{ \Illuminate\Support\Str::limit($service->localized('service_description'), 90) }}</span>
                      </span>
                      <span class="tcw-service_arrow"><i class="fas fa-arrow-right"></i></span>
                    </a>
                  @endforeach
                </div>
              </div>
            </li>
            <li class="tcw-nav_item {{ $isPortfolio ? 'is-active' : '' }}">
              <a href="{{ url('/portfolio') }}">{{ __('website.nav.portfolio') }}</a>
            </li>
            <li class="tcw-nav_item {{ $isOffers ? 'is-active' : '' }}">
              <a href="{{ route('website.offers') }}">{{ __('website.nav.offers') }}</a>
            </li>
            <li class="tcw-nav_item {{ $isIndustries ? 'is-active' : '' }}">
              <a href="{{ route('website.industries') }}">{{ __('website.nav.industries') }}</a>
            </li>
            <li class="tcw-nav_item {{ $isTestimonials ? 'is-active' : '' }}">
              <a href="{{ route('website.testimonials') }}">{{ __('website.nav.testimonials') }}</a>
            </li>
            <li class="tcw-nav_item {{ $isBlog ? 'is-active' : '' }}">
              <a href="{{ url('/blog') }}">{{ __('website.nav.blog') }}</a>
            </li>
            <li class="tcw-nav_item {{ $isQuote ? 'is-active' : '' }}">
              <a href="{{ route('website.quote-generator') }}">{{ __('website.nav.quote') }}</a>
            </li>
          </ul>
        </nav>
      </div>

      <div class="cs-main_header_right">
        <div class="tcw-header_actions">
          @auth
            <a href="{{ auth()->user()->isAdmin() ? route('dashboard') : route('user.dashboard') }}" class="tcw-header_auth" aria-label="{{ __('website.nav.dashboard') }}" title="{{ __('website.nav.dashboard') }}">
              <i class="fas fa-user"></i>
            </a>
          @else
            <a href="{{ route('login') }}" class="tcw-header_auth" aria-label="{{ __('website.nav.login') }}" title="{{ __('website.nav.login') }}">
              <i class="fas fa-user"></i>
            </a>
          @endauth
          <div class="tcw-language-switch" aria-label="{{ __('website.language.label') }}">
            <a href="{{ route('language.switch', 'en') }}" class="{{ $isArabic ? '' : 'is-active' }}">EN</a>
            <a href="{{ route('language.switch', 'ar') }}" class="{{ $isArabic ? 'is-active' : '' }}">AR</a>
          </div>
          <a href="{{ url('/contact') }}" class="tcw-header_cta">{{ __('website.nav.contact') }}</a>
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
        <a href="{{ url('/') }}" class="tcw-mobile_link {{ $isHome ? 'is-active' : '' }}">{{ __('website.nav.home') }}</a>
        <a href="{{ url('/about') }}" class="tcw-mobile_link {{ $isAbout ? 'is-active' : '' }}">{{ __('website.nav.about') }}</a>

        <div class="tcw-mobile_group {{ $isService ? 'is-open' : '' }}">
          <button class="tcw-mobile_group_toggle" type="button" aria-expanded="{{ $isService ? 'true' : 'false' }}">
            <span>{{ __('website.nav.services') }}</span>
            <i class="fas fa-plus"></i>
          </button>
          <div class="tcw-mobile_group_body" @unless($isService) hidden @endunless>
            @foreach ($servicesMenuItems as $service)
              <a href="{{ $service->detail ? route('website.service-details.show', $service->detail->slug) : route('website.services') }}" class="tcw-mobile_sublink">
                <span class="tcw-mobile_sublink_icon">
                  @if($service->icon)
                    <img src="{{ asset($service->icon) }}" alt="{{ $service->localized('service_title') }}" width="42" height="42" loading="lazy" decoding="async">
                  @else
                    <i class="fas fa-briefcase"></i>
                  @endif
                </span>
              <span class="tcw-mobile_sublink_content">
                <span class="tcw-mobile_sublink_title">{{ $service->localized('service_title') }}</span>
                <span class="tcw-mobile_sublink_text">{{ \Illuminate\Support\Str::limit($service->localized('service_description'), 80) }}</span>
              </span>
            </a>
          @endforeach
        </div>
        </div>

        <a href="{{ url('/portfolio') }}" class="tcw-mobile_link {{ $isPortfolio ? 'is-active' : '' }}">{{ __('website.nav.portfolio') }}</a>
        <a href="{{ route('website.offers') }}" class="tcw-mobile_link {{ $isOffers ? 'is-active' : '' }}">{{ __('website.nav.offers') }}</a>
        <a href="{{ route('website.industries') }}" class="tcw-mobile_link {{ $isIndustries ? 'is-active' : '' }}">{{ __('website.nav.industries') }}</a>
        <a href="{{ route('website.testimonials') }}" class="tcw-mobile_link {{ $isTestimonials ? 'is-active' : '' }}">{{ __('website.nav.testimonials') }}</a>
        <a href="{{ url('/blog') }}" class="tcw-mobile_link {{ $isBlog ? 'is-active' : '' }}">{{ __('website.nav.blog') }}</a>
        <a href="{{ route('website.quote-generator') }}" class="tcw-mobile_link {{ $isQuote ? 'is-active' : '' }}">{{ __('website.nav.quote_generator') }}</a>
        <div class="tcw-language-switch tcw-language-switch-mobile" aria-label="{{ __('website.language.label') }}">
          <a href="{{ route('language.switch', 'en') }}" class="{{ $isArabic ? '' : 'is-active' }}">{{ __('website.language.english') }}</a>
          <a href="{{ route('language.switch', 'ar') }}" class="{{ $isArabic ? 'is-active' : '' }}">{{ __('website.language.arabic') }}</a>
        </div>
        @auth
          <a href="{{ auth()->user()->isAdmin() ? route('dashboard') : route('user.dashboard') }}" class="tcw-mobile_link">{{ __('website.nav.dashboard') }}</a>
          <form action="{{ route('logout') }}" method="POST" class="tcw-mobile_auth_form">
            @csrf
            <button type="submit">{{ __('website.nav.logout') }}</button>
          </form>
        @else
          <a href="{{ route('login') }}" class="tcw-mobile_link">{{ __('website.nav.login') }}</a>
        @endauth
        <div class="tcw-mobile_cta_wrap">
          <p>{{ __('website.nav.project_prompt') }}</p>
          <a href="{{ url('/contact') }}" class="tcw-header_cta tcw-header_cta_full">{{ __('website.nav.start_project') }}</a>
        </div>
      </div>
    </div>
  </div>
</header>
<!-- End Header Section -->
