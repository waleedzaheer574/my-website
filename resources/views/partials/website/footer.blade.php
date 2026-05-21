<!-- Footer Section -->
@php
  $companySetting = $websiteCompanySetting ?? null;
  $websiteLogo = $companySetting?->logo
    ? asset('storage/' . $companySetting->logo) . '?v=' . optional($companySetting->updated_at)->timestamp
    : asset('website/assets/img/design-agency/logo.svg');
  $companyEmail = $companySetting?->email ?: 'youremail@gmail.com';
  $companyPhone = $companySetting?->phone ?: '+012 3456 7890';
  $footerServices = ($websiteServices ?? collect())->take(6);
  $newsletterError = session('errors')?->getBag('newsletter')?->first('email');
  $footerSocialLinks = [
    ['url' => '#', 'icon' => 'fab fa-fonticons-fi', 'label' => 'Fiverr'],
    ['url' => $companySetting?->facebook ?: '#', 'icon' => 'fab fa-facebook-f', 'label' => 'Facebook'],
    ['url' => $companySetting?->linkedin ?: '#', 'icon' => 'fab fa-linkedin-in', 'label' => 'LinkedIn'],
    ['url' => $companySetting?->instagram ?: '#', 'icon' => 'fab fa-instagram', 'label' => 'Instagram'],
  ];
@endphp

<footer class="cs-footer cs-style3 tcw-footer wow fadeIn" data-wow-duration="1s" data-wow-delay="0.3s">
  <div class="cs-footer_bg"></div>
  <div class="container">
    <div class="cs-height_115 cs-height_lg_75"></div>
    <div class="row">
      <div class="col-lg-3 col-md-6">
        <div class="cs-footer_item cs-text_widgert">
          <div class="cs-text_widgert_content tcw-footer-logo">
            <img src="{{ $websiteLogo }}" alt="Multitechwave logo" width="240" height="100" loading="lazy" decoding="async">
          </div>
        </div>
        <div class="cs-footer_item cs-address_widgert">
          <ul>
            <li><i class="far fa-envelope-open"></i>{{ $companyEmail }}</li>
            <li><i class="far fa-address-book"></i>{{ $companyPhone }}</li>
          </ul>
        </div>
      </div><!-- .col -->
      <div class="col-lg-3 col-md-6">
        <div class="cs-footer_item widget_nav_menu">
          <h2 class="cs-widget_title">Services</h2>
          <ul class="menu">
            @forelse($footerServices as $service)
              <li>
                <a href="{{ $service->detail ? route('website.service-details.show', $service->detail->slug) : route('website.services') }}">
                  {{ $service->service_title }}
                </a>
              </li>
            @empty
              <li><a href="{{ route('website.services') }}">Services</a></li>
            @endforelse
          </ul>
        </div>
      </div><!-- .col -->
      <div class="col-lg-3 col-md-6">
        <div class="cs-footer_item widget_nav_menu">
          <h2 class="cs-widget_title">Company</h2>
          <ul class="menu">
            <li><a href="{{ url('/privacy-policy') }}">Privacy policy</a></li>
            <li><a href="{{ url('/sitemap') }}">Sitemap</a></li>
            <li><a href="{{ url('/careers') }}">Careers</a></li>
            <li><a href="{{ url('/terms') }}">Terms</a></li>
          </ul>
        </div>
      </div><!-- .col -->
      <div class="col-lg-3 col-md-6">
        <div class="cs-footer_item cs-address_widgert">
          <h2 class="cs-widget_title">Subscribe Us</h2>
          <div class="cs-footer_newsletter cs-style1">
            <form action="{{ route('newsletter-subscriptions.store') }}" method="POST" class="cs-footer_newsletter_form">
              @csrf
              <input type="email" name="email" class="cs-footer_newsletter_input" placeholder="Enter your email" required>
              <button type="submit" class="cs-footer_newsletter_btn cs-accent_bg cs-white cs-accent_bg_2_hover" aria-label="Subscribe"><i class="fas fa-paper-plane"></i></button>
            </form>
            @if(session('newsletter_success'))
              <div class="tcw-newsletter-message" role="status">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('newsletter_success') }}</span>
              </div>
            @endif
            @if($newsletterError)
              <div class="tcw-newsletter-error" role="alert">
                <i class="fas fa-exclamation-circle"></i>
                <span>{{ $newsletterError }}</span>
              </div>
            @endif
          </div>
        </div>
        <div class="cs-footer_item">
          <div class="cs-social_btns cs-style1">
            @foreach($footerSocialLinks as $socialLink)
              <a href="{{ $socialLink['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $socialLink['label'] }}">
                <i class="{{ $socialLink['icon'] }}"></i>
              </a>
            @endforeach
          </div>
        </div>
      </div><!-- .col -->
    </div>
    <div class="cs-height_60 cs-height_lg_40"></div>
    <div class="tcw-footer-copyright">
      @copyright Multitechwave
    </div>
  </div>
</footer>
<!-- Footer Section -->

<!-- Start Video Popup -->
<div class="cs-video_popup">
  <div class="cs-video_popup_overlay"></div>
  <div class="cs-video_popup_content">
    <div class="cs-video_popup_layer"></div>
    <div class="cs-video_popup_container">
      <div class="cs-video_popup_align">
        <div class="embed-responsive embed-responsive-16by9">
          <iframe class="embed-responsive-item" src="about:blank"></iframe>
        </div>
      </div>
      <div class="cs-video_popup_close"></div>
    </div>
  </div>
</div>
<!-- End Video Popup -->
