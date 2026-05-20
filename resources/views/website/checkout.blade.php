@extends('layouts.website')

@section('title', 'Checkout - '.$offer->title)
@section('hide_global_faqs', '1')

@section('content')
@php
  $addonOptions = [
      'extra_pages' => ['label' => 'Extra Pages (5 Pages)', 'price' => 200],
      'seo_optimization' => ['label' => 'SEO Optimization', 'price' => 150],
      'premium_design' => ['label' => 'Premium Design', 'price' => 200],
      'content_writing' => ['label' => 'Content Writing', 'price' => 100],
  ];
  $selectedAddons = collect(old('addons', ['seo_optimization']));
  $addonTotal = $selectedAddons->sum(fn ($addon) => $addonOptions[$addon]['price'] ?? 0);
  $total = $offer->price + $addonTotal;
@endphp

<main class="tcw-saas-page tcw-checkout-page">
  <section class="tcw-premium-checkout">
    <div class="container">
      <div class="tcw-checkout-steps" aria-label="Checkout steps">
        @foreach(['Billing Details', 'Review Order', 'Payment', 'Confirmation'] as $step)
          <div class="{{ $loop->first ? 'is-active' : '' }}">
            <b>{{ $loop->iteration }}</b>
            <span>{{ $step }}</span>
          </div>
        @endforeach
      </div>

      <div class="tcw-checkout-secure-head">
        <span><i class="fas fa-lock"></i> Secure Checkout</span>
        <small><i class="fas fa-shield-alt"></i> SSL Secured 256-bit Encryption</small>
      </div>

      <form action="{{ route('website.checkout.store', $offer->slug) }}" method="POST" enctype="multipart/form-data" class="tcw-premium-checkout-grid">
        @csrf

        <div class="tcw-checkout-form-card">
          <section class="tcw-checkout-block">
            <div class="tcw-checkout-block-head">
              <i class="far fa-user"></i>
              <div>
                <h2>Billing Details</h2>
                <p>Please provide your information to continue</p>
              </div>
            </div>

            <div class="tcw-premium-fields">
              <label>Full Name <sup>*</sup><input name="client_name" value="{{ old('client_name', auth()->user()->name) }}" required></label>
              <label>Email Address <sup>*</sup><input type="email" name="client_email" value="{{ old('client_email', auth()->user()->email) }}" required></label>
              <label>Phone Number <sup>*</sup><input name="client_phone" value="{{ old('client_phone') }}" placeholder="+971 50 123 4567" required></label>
              <label>Company Name (Optional)<input name="company_name" value="{{ old('company_name') }}" placeholder="Multitechwave LLC"></label>
              <label>Country <sup>*</sup><select><option>United Arab Emirates</option><option>Pakistan</option><option>Saudi Arabia</option><option>United States</option></select></label>
              <label>City <sup>*</sup><input placeholder="Dubai"></label>
              <label>Address Line 1 <sup>*</sup><input placeholder="123 Business Bay"></label>
              <label>ZIP / Postal Code <sup>*</sup><input placeholder="12345"></label>
            </div>
          </section>

          <section class="tcw-checkout-block">
            <div class="tcw-checkout-block-head">
              <i class="fas fa-clipboard-list"></i>
              <div>
                <h2>Project Requirements</h2>
                <p>Tell us about your project</p>
              </div>
            </div>
            <textarea name="requirements" placeholder="Describe your project requirements, goals, and any specific details...">{{ old('requirements') }}</textarea>
            <label class="tcw-upload-box">
              <input type="file" multiple>
              <i class="fas fa-cloud-upload-alt"></i>
              <b>Upload Files (Optional)</b>
              <span>Drag & drop files or click to browse</span>
              <small>PDF, DOC, JPG, PNG (Max. 10MB)</small>
            </label>
          </section>

          <section class="tcw-checkout-block">
            <div class="tcw-checkout-block-head">
              <i class="far fa-credit-card"></i>
              <div>
                <h2>Payment Method</h2>
                <p>Choose your preferred payment method</p>
              </div>
            </div>

            <div class="tcw-premium-payments">
              @foreach(['credit_card' => 'Credit / Debit Card', 'paypal' => 'PayPal', 'stripe' => 'Stripe'] as $value => $label)
                <label class="{{ $loop->first ? 'is-active' : '' }}">
                  <input type="radio" name="payment_method" value="{{ $value }}" {{ old('payment_method', 'credit_card') === $value ? 'checked' : '' }}>
                  <span>
                    <b>{{ $label }}</b>
                    <small>{{ $value === 'paypal' ? 'Pay using your PayPal account' : ($value === 'stripe' ? 'Secure payment powered by Stripe' : 'Pay securely using your card') }}</small>
                  </span>
                  <strong>{{ $value === 'paypal' ? 'PayPal' : ($value === 'stripe' ? 'stripe' : 'VISA  MC  AMEX') }}</strong>
                </label>
              @endforeach
            </div>

            <p class="tcw-payment-note"><i class="fas fa-info-circle"></i>You will be redirected to our secure payment gateway to complete your purchase.</p>

            <div class="tcw-checkout-trust-row">
              <span><i class="fas fa-user-shield"></i><b>100% Secure Payment</b><small>Your payment is safe with us</small></span>
              <span><i class="fas fa-headset"></i><b>24/7 Customer Support</b><small>We are here to help you</small></span>
              <span><i class="fas fa-stopwatch"></i><b>Money Back Guarantee</b><small>100% refund within 7 days</small></span>
            </div>
          </section>
        </div>

        <aside class="tcw-checkout-summary-wrap">
          <section class="tcw-checkout-summary-card">
            <h2>Order Summary</h2>
            <div class="tcw-summary-product">
              <div class="tcw-summary-thumb"><i class="fas fa-laptop-code"></i></div>
              <div>
                <h3>{{ $offer->title }}</h3>
                <span>Premium Package</span>
              </div>
            </div>

            <ul class="tcw-summary-features">
              @foreach(array_slice($offer->features ?? [], 0, 7) as $feature)
                <li><i class="fas fa-link"></i>{{ $feature }}</li>
              @endforeach
            </ul>

            <div class="tcw-summary-lines">
              <div><span>Package Price</span><b>{{ $offer->price_label }}</b></div>
              <div><span>Delivery Time</span><b>{{ $offer->delivery_time ?: 'Confirmed after checkout' }}</b></div>
              <div><span>Subtotal</span><b>{{ $offer->price_label }}</b></div>
            </div>

            <div class="tcw-summary-addons">
              <h3>Add-ons</h3>
              @foreach($addonOptions as $value => $addon)
                <label>
                  <input type="checkbox" name="addons[]" value="{{ $value }}" {{ $selectedAddons->contains($value) ? 'checked' : '' }}>
                  <span>{{ $addon['label'] }}</span>
                  <b>{{ $offer->currency }} {{ number_format($addon['price']) }}</b>
                </label>
              @endforeach
            </div>

            <div class="tcw-summary-coupon">
              <h3>Coupon Code</h3>
              <div>
                <input name="coupon_code" value="{{ old('coupon_code') }}" placeholder="Enter coupon code">
                <button type="button">Apply</button>
              </div>
            </div>

            <div class="tcw-summary-total">
              <span>Total Amount</span>
              <strong>{{ $offer->currency }} {{ number_format($total) }}</strong>
            </div>

            <button type="submit" class="tcw-checkout-submit">Proceed to Payment <i class="fas fa-arrow-right"></i></button>
            <small>By proceeding, you agree to our <a href="{{ url('/terms') }}">Terms & Conditions</a></small>
          </section>

          <section class="tcw-checkout-safe-card">
            <div>
              <h2>Why You're Safe With Us</h2>
              <ul>
                <li><i class="fas fa-check-circle"></i>256-bit SSL encryption</li>
                <li><i class="fas fa-check-circle"></i>PCI DSS compliant</li>
                <li><i class="fas fa-check-circle"></i>Secure & trusted payment gateways</li>
                <li><i class="fas fa-check-circle"></i>100% money-back guarantee</li>
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
