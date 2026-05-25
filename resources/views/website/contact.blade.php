@extends('layouts.website')

@section('content')
  @php
    $contactInfo = [
      ['icon' => 'fas fa-phone-alt', 'value' => $companySetting?->phone],
      ['icon' => 'far fa-address-book', 'value' => $companySetting?->email],
      ['icon' => 'fas fa-fax', 'value' => $companySetting?->fax],
      ['icon' => 'fas fa-map-marker-alt', 'value' => $companySetting?->address, 'is_html' => true],
    ];

    $socialLinks = [
      ['icon' => 'fab fa-facebook-f', 'url' => $companySetting?->facebook],
      ['icon' => 'fab fa-instagram', 'url' => $companySetting?->instagram],
      ['icon' => 'fab fa-linkedin-in', 'url' => $companySetting?->linkedin],
      ['icon' => 'fab fa-youtube', 'url' => $companySetting?->youtube],
      ['icon' => 'fab fa-tiktok', 'url' => $companySetting?->tiktok],
      ['icon' => 'fab fa-pinterest-p', 'url' => $companySetting?->pinterest],
    ];
  @endphp

  <div class="cs-hero cs-style8 cs-type1 cs-center text-center" data-src="{{ asset('website/assets/img/design-agency/icon-box-bg2.jpg') }}">
    <div class="container">
      <div class="cs-hero_text">
        <h1 class="cs-hero_title"><b class="cs-accent_color">{{ __('website.contact.title') }}</b></h1>
        <a href="#next_section" class="cs-down_btn cs-accent_color cs-accent_color_2_hover cs-smoth_scroll"><i class="fas fa-angle-down"></i></a>
      </div>
    </div>
    <div class="cs-hero_blur_shape">
      <div><img src="{{ asset('website/assets/img/design-agency/hero-blur-shape.png') }}" alt="" width="720" height="720" loading="lazy" decoding="async"></div>
    </div>
  </div>

  <div id="next_section">
    <div class="cs-height_140 cs-height_lg_80"></div>
    <div class="container">
      <div class="cs-contact cs-style2 cs-white_bg tcw-contact-form-shell">
        <div class="cs-contact_left cs-accent_bg position-relative">
          <div class="cs-contact_info_wrap">
            <h4 class="cs-contact_title cs-semi_bold cs-white">{{ __('website.contact.information') }}</h4>
            <div class="cs-height_10 cs-height_lg_10"></div>
            <ul class="cs-contact_info cs-mp0 cs-white">
              @foreach($contactInfo as $item)
                @if(!blank($item['value']))
                  <li>
                    <i class="{{ $item['icon'] }}"></i>
                    @if(!empty($item['is_html']))
                      {!! nl2br(e($item['value'])) !!}
                    @else
                      {{ $item['value'] }}
                    @endif
                  </li>
                @endif
              @endforeach
            </ul>
          </div>
          <div class="cs-social_btns_wrap">
            <div class="cs-social_btns cs-style1 cs-white_50">
              @foreach($socialLinks as $socialLink)
                @if(!blank($socialLink['url']))
                  <a href="{{ $socialLink['url'] }}" target="_blank" rel="noopener noreferrer" class="cs-accent_color_2_hover">
                    <i class="{{ $socialLink['icon'] }}"></i>
                  </a>
                @endif
              @endforeach
            </div>
          </div>
          <div class="cs-circle cs-accent_60_bg_2"></div>
        </div>

        <div class="cs-contact_right cs-accent_10_bg">
          <div class="service-card">
            <div class="tcw-form_badge">{{ __('website.common.free_consultation') }}</div>
            <h3 class="form-title">{{ __('website.contact.consultation_title') }}</h3>
            <p class="tcw-form_intro">{{ __('website.contact.consultation_text') }}</p>

            @if(session('success'))
              <div class="alert-success">{{ session('success') }}</div>
            @endif

            @if($errors->any())
              <div class="alert-danger">
                <ul>
                  @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            <form action="{{ route('services.store.public') }}" method="POST" id="contact-service-request-form" data-service-request-form novalidate>
              @csrf
              <div class="tcw-form-field">
                <input type="text" name="full_name" placeholder="{{ __('website.common.full_name') }}" value="{{ old('full_name') }}" class="@error('full_name') is-invalid @enderror" required>
                @error('full_name') <span class="field-error">{{ $message }}</span> @enderror
              </div>
              <div class="tcw-form-field">
                <input type="text" name="company_name" placeholder="{{ __('website.common.company_name') }}" value="{{ old('company_name') }}" class="@error('company_name') is-invalid @enderror" required>
                @error('company_name') <span class="field-error">{{ $message }}</span> @enderror
              </div>
              <div class="tcw-form-field">
                <input type="text" name="company_website" placeholder="{{ __('website.common.company_website') }}" value="{{ old('company_website') }}" class="@error('company_website') is-invalid @enderror">
                @error('company_website') <span class="field-error">{{ $message }}</span> @enderror
              </div>
              <div class="tcw-form-field">
                <input type="email" name="company_email" placeholder="{{ __('website.common.company_email') }}" value="{{ old('company_email') }}" class="@error('company_email') is-invalid @enderror" required>
                @error('company_email') <span class="field-error">{{ $message }}</span> @enderror
              </div>
              <div class="tcw-form-field">
                <div class="phone-field-wrap">
                  <input type="tel" id="contact_full_phone" name="phone_no" placeholder="{{ __('website.common.phone_number') }}" autocomplete="tel" value="{{ old('phone_no') }}" class="@error('phone_no') is-invalid @enderror" required>
                  <input type="hidden" name="country" id="contact_country_name">
                </div>
                @error('phone_no') <span class="field-error">{{ $message }}</span> @enderror
              </div>
              <div class="tcw-form-field">
                <select name="service_type" class="@error('service_type') is-invalid @enderror" required>
                  <option value="" disabled {{ old('service_type') ? '' : 'selected' }}>{{ __('website.common.choose_service') }}</option>
                  @foreach($services as $service)
                    <option value="{{ $service->service_title }}" {{ old('service_type') === $service->service_title ? 'selected' : '' }}>
                      {{ $service->localized('service_title') }}
                    </option>
                  @endforeach
                </select>
                @error('service_type') <span class="field-error">{{ $message }}</span> @enderror
              </div>
              <button type="submit">{{ __('website.common.submit_request') }}</button>
            </form>
          </div>
        </div>
      </div>
    </div>
    <div class="cs-height_140 cs-height_lg_80"></div>
  </div>
@endsection
