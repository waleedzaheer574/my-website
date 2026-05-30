@extends('layouts.website')

@section('content')
  <main class="tcw-quote-page">
    <section class="tcw-quote-hero">
      <div class="container">
        <div class="tcw-quote-hero-grid">
          <div class="tcw-quote-copy wow fadeInUp" data-wow-duration="1s">
            <span class="tcw-detail-eyebrow">{{ __('website.quote.label') }}</span>
            <h1>{{ __('website.quote.title') }}</h1>
            <p>{{ __('website.quote.text') }}</p>
          </div>
          <div class="tcw-quote-orb wow fadeIn" data-wow-duration="1s" data-wow-delay="0.15s" aria-hidden="true">
            <div>
              <span>PDF</span>
              <strong>{{ __('website.quote.proposal') }}</strong>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="tcw-quote-section">
      <div class="container">
        <form action="{{ route('website.quote-generator.store') }}" method="POST" class="tcw-quote-form wow fadeInUp" data-wow-duration="1s" data-ajax-request-form>
          @csrf
          <div class="tcw-quote-form-head">
            <span>{{ __('website.quote.step') }}</span>
            <h2>{{ __('website.quote.need') }}</h2>
          </div>

          @if(isset($errors) && $errors->any())
            <div class="tcw-quote-alert tcw-quote-alert-error" role="alert">
              <strong>Please check the form.</strong>
              <span>{{ $errors->first() }}</span>
            </div>
          @endif

          <div class="tcw-quote-fields">
            <label>
              <span>{{ __('website.quote.name') }}</span>
              <input type="text" name="client_name" value="{{ old('client_name') }}" required>
            </label>
            <label>
              <span>{{ __('website.quote.email') }}</span>
              <input type="email" name="client_email" value="{{ old('client_email') }}" required>
            </label>
            <label>
              <span>{{ __('website.quote.phone') }}</span>
              <div class="phone-field-wrap">
                <input type="tel" id="quote_generator_phone" name="client_phone" placeholder="Phone Number" autocomplete="tel" value="{{ old('client_phone') }}">
                <input type="hidden" name="client_country" id="quote_generator_country">
              </div>
            </label>
            <label>
              <span>{{ __('website.quote.company') }}</span>
              <input type="text" name="company_name" value="{{ old('company_name') }}">
            </label>
            <label>
              <span>{{ __('website.quote.service') }}</span>
              <div class="tcw-service-select">
                <select name="service_id" required>
                  <option value="">{{ __('website.quote.select_service') }}</option>
                  @foreach($services as $service)
                    <option value="{{ $service->id }}" @selected(old('service_id') == $service->id)>{{ $service->localized('service_title') }}</option>
                  @endforeach
                </select>
              </div>
            </label>
            <label>
              <span>{{ __('website.quote.budget') }}</span>
              <input type="text" name="budget_range" list="quote_budget_options" value="{{ old('budget_range') }}" placeholder="Example: $2,000 or $2,000 - $5,000" required>
              <datalist id="quote_budget_options">
                @foreach($budgetOptions as $key => $option)
                  <option value="{{ $option['label'] }}"></option>
                @endforeach
              </datalist>
            </label>
            <label>
              <span>{{ __('website.quote.timeline') }}</span>
              <select name="timeline">
                @foreach($timelineOptions as $key => $label)
                  <option value="{{ $key }}" @selected(old('timeline') === $key)>{{ $label }}</option>
                @endforeach
              </select>
            </label>
            <label class="tcw-quote-field-wide">
              <span>{{ __('website.quote.requirements') }}</span>
              <textarea name="requirements" rows="6" required placeholder="Tell us about your goals, pages/features, integrations, content, references, and launch deadline.">{{ old('requirements') }}</textarea>
            </label>
          </div>

          <button type="submit" class="tcw-quote-submit" data-quote-submit>
            {{ __('website.quote.submit') }} <i class="fas fa-file-invoice-dollar"></i>
          </button>
        </form>
      </div>
    </section>
  </main>
@endsection
