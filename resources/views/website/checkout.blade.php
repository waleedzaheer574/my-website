@extends('layouts.website')

@section('title', __('website.checkout.title').' - '.$offer->localized('title'))
@section('hide_global_faqs', '1')

@section('content')
@php
  $addonOptions = [
      'extra_pages' => ['label' => __('website.checkout.addons_items.0'), 'price' => 200],
      'seo_optimization' => ['label' => __('website.checkout.addons_items.1'), 'price' => 150],
      'premium_design' => ['label' => __('website.checkout.addons_items.2'), 'price' => 200],
      'content_writing' => ['label' => __('website.checkout.addons_items.3'), 'price' => 100],
  ];
  $selectedAddons = collect(old('addons', ['seo_optimization']));
  $addonTotal = $selectedAddons->sum(fn ($addon) => $addonOptions[$addon]['price'] ?? 0);
  $total = $offer->price + $addonTotal;
@endphp

<main class="tcw-saas-page tcw-checkout-page">
  <section class="tcw-premium-checkout">
    <div class="container">
      <div class="tcw-checkout-steps" aria-label="{{ __('website.checkout.steps_label') }}">
        @foreach(__('website.checkout.steps') as $step)
          <div class="{{ $loop->first ? 'is-active' : '' }}">
            <b>{{ $loop->iteration }}</b>
            <span>{{ $step }}</span>
          </div>
        @endforeach
      </div>

      <div class="tcw-checkout-secure-head">
        <span><i class="fas fa-lock"></i> {{ __('website.checkout.secure') }}</span>
        <small><i class="fas fa-shield-alt"></i> {{ __('website.checkout.ssl') }}</small>
      </div>

      <form action="{{ route('website.checkout.store', $offer->slug) }}" method="POST" enctype="multipart/form-data" class="tcw-premium-checkout-grid">
        @csrf

        <div class="tcw-checkout-form-card">
          <section class="tcw-checkout-block">
            <div class="tcw-checkout-block-head">
              <i class="far fa-user"></i>
              <div>
                <h2>{{ __('website.checkout.billing') }}</h2>
                <p>{{ __('website.checkout.continue') }}</p>
              </div>
            </div>

            <div class="tcw-premium-fields">
              <label>{{ __('website.common.full_name') }} <sup>*</sup><input name="client_name" value="{{ old('client_name', auth()->user()->name) }}" required></label>
              <label>{{ __('website.checkout.email') }} <sup>*</sup><input type="email" name="client_email" value="{{ old('client_email', auth()->user()->email) }}" required></label>
              <label>{{ __('website.common.phone_number') }} <sup>*</sup><input name="client_phone" value="{{ old('client_phone') }}" placeholder="+971 50 123 4567" required></label>
              <label>{{ __('website.checkout.company_optional') }}<input name="company_name" value="{{ old('company_name') }}" placeholder="Multitechwave LLC"></label>
              <label>{{ __('website.checkout.country') }} <sup>*</sup><select>@foreach(__('website.checkout.countries') as $country)<option>{{ $country }}</option>@endforeach</select></label>
              <label>{{ __('website.checkout.city') }} <sup>*</sup><input placeholder="Dubai"></label>
              <label>{{ __('website.checkout.address') }} <sup>*</sup><input placeholder="123 Business Bay"></label>
              <label>{{ __('website.checkout.postal') }} <sup>*</sup><input placeholder="12345"></label>
            </div>
          </section>

          <section class="tcw-checkout-block">
            <div class="tcw-checkout-block-head">
              <i class="fas fa-clipboard-list"></i>
              <div>
                <h2>{{ __('website.checkout.requirements') }}</h2>
                <p>{{ __('website.checkout.project_prompt') }}</p>
              </div>
            </div>
            <textarea name="requirements" placeholder="{{ __('website.checkout.project_placeholder') }}">{{ old('requirements') }}</textarea>
            <label class="tcw-upload-box">
              <input type="file" multiple>
              <i class="fas fa-cloud-upload-alt"></i>
              <b>{{ __('website.checkout.upload') }}</b>
              <span>{{ __('website.checkout.upload_prompt') }}</span>
              <small>{{ __('website.checkout.upload_formats') }}</small>
            </label>
          </section>

          <section class="tcw-checkout-block">
            <div class="tcw-checkout-block-head">
              <i class="far fa-credit-card"></i>
              <div>
                <h2>{{ __('website.checkout.payment') }}</h2>
                <p>{{ __('website.checkout.payment_prompt') }}</p>
              </div>
            </div>

            <div class="tcw-premium-payments">
              @foreach(__('website.checkout.methods') as $value => $method)
                <label class="{{ $loop->first ? 'is-active' : '' }}">
                  <input type="radio" name="payment_method" value="{{ $value }}" {{ old('payment_method', 'credit_card') === $value ? 'checked' : '' }}>
                  <span>
                    <b>{{ $method['title'] }}</b>
                    <small>{{ $method['text'] }}</small>
                  </span>
                  <strong>{{ $value === 'paypal' ? 'PayPal' : ($value === 'stripe' ? 'stripe' : 'VISA  MC  AMEX') }}</strong>
                </label>
              @endforeach
            </div>

            <p class="tcw-payment-note"><i class="fas fa-info-circle"></i>{{ __('website.checkout.redirect') }}</p>

            <div class="tcw-checkout-trust-row">
              @foreach(__('website.checkout.trust') as $item)
                <span><i class="fas {{ ['fa-user-shield', 'fa-headset', 'fa-stopwatch'][$loop->index] }}"></i><b>{{ $item['title'] }}</b><small>{{ $item['text'] }}</small></span>
              @endforeach
            </div>
          </section>
        </div>

        <aside class="tcw-checkout-summary-wrap">
          <section class="tcw-checkout-summary-card">
            <h2>{{ __('website.checkout.summary') }}</h2>
            <div class="tcw-summary-product">
              <div class="tcw-summary-thumb"><i class="fas fa-laptop-code"></i></div>
              <div>
                <h3>{{ $offer->localized('title') }}</h3>
                <span>{{ __('website.checkout.package') }}</span>
              </div>
            </div>

            <ul class="tcw-summary-features">
              @foreach(array_slice($offer->localized('features') ?? [], 0, 7) as $feature)
                <li><i class="fas fa-link"></i>{{ $feature }}</li>
              @endforeach
            </ul>

            <div class="tcw-summary-lines">
              <div><span>{{ __('website.checkout.package_price') }}</span><b>{{ $offer->price_label }}</b></div>
              <div><span>{{ __('website.checkout.delivery_time') }}</span><b>{{ $offer->delivery_time ?: __('website.offer_detail.timeline_after') }}</b></div>
              <div><span>{{ __('website.checkout.subtotal') }}</span><b>{{ $offer->price_label }}</b></div>
            </div>

            <div class="tcw-summary-addons">
              <h3>{{ __('website.checkout.addons') }}</h3>
              @foreach($addonOptions as $value => $addon)
                <label>
                  <input type="checkbox" name="addons[]" value="{{ $value }}" {{ $selectedAddons->contains($value) ? 'checked' : '' }}>
                  <span>{{ $addon['label'] }}</span>
                  <b>{{ $offer->currency }} {{ number_format($addon['price']) }}</b>
                </label>
              @endforeach
            </div>

            <div class="tcw-summary-coupon">
              <h3>{{ __('website.checkout.coupon') }}</h3>
              <div>
                <input name="coupon_code" value="{{ old('coupon_code') }}" placeholder="{{ __('website.checkout.coupon_placeholder') }}">
                <button type="button">{{ __('website.checkout.apply') }}</button>
              </div>
            </div>

            <div class="tcw-summary-total">
              <span>{{ __('website.checkout.total') }}</span>
              <strong>{{ $offer->currency }} {{ number_format($total) }}</strong>
            </div>

            <button type="submit" class="tcw-checkout-submit">{{ __('website.checkout.proceed') }} <i class="fas fa-arrow-right"></i></button>
            <small>{{ __('website.checkout.terms') }} <a href="{{ url('/terms') }}">{{ __('website.checkout.terms_link') }}</a></small>
          </section>

          <section class="tcw-checkout-safe-card">
            <div>
              <h2>{{ __('website.checkout.safe_title') }}</h2>
              <ul>
                @foreach(__('website.checkout.safe_items') as $item)
                  <li><i class="fas fa-check-circle"></i>{{ $item }}</li>
                @endforeach
              </ul>
            </div>
            <i class="fas fa-shield-alt"></i>
          </section>
        </aside>
      </form>
    </div>
  </section>
</main>
@endsection
