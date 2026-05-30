@extends('layouts.website')

@section('content')
  <main class="tcw-quote-page">
    <section class="tcw-quote-result-section">
      <div class="container">
        <div class="tcw-quote-result-shell wow fadeInUp" data-wow-duration="1s">
          <div class="tcw-quote-result-glow" aria-hidden="true"></div>
          <div class="tcw-quote-result-card">
            <div class="tcw-quote-result-left">
              <span class="tcw-detail-eyebrow">{{ __('website.quote.instant') }}</span>
              <h1>{{ $quote->reference }}</h1>
              <p>{{ __('website.quote.ready', ['service' => $quote->service_label]) }}</p>
              <div class="tcw-quote-actions">
                <a href="{{ route('website.quote-generator.download', $quote->public_token) }}" class="tcw-quote-submit">
                  {{ __('website.quote.download') }} <i class="fas fa-file-pdf"></i>
                </a>
                <a href="{{ route('website.quote-generator.proposal', $quote->public_token) }}" class="tcw-quote-secondary">{{ __('website.quote.view_proposal') }}</a>
                <a href="{{ route('website.quote-generator') }}" class="tcw-quote-secondary">{{ __('website.quote.another') }}</a>
              </div>
            </div>

            <div class="tcw-quote-result-panel">
              <div class="tcw-quote-result-panel-top">
                <span>{{ __('website.quote.investment') }}</span>
                <i class="fas fa-file-invoice-dollar"></i>
              </div>
              <div class="tcw-quote-price">
                <span>{{ __('website.quote.total_budget') }}</span>
                <strong>{{ $quote->estimate_label }}</strong>
                <small>{{ __('website.quote.flexible') }}</small>
              </div>
              <div class="tcw-quote-result-grid">
                <div>
                  <i class="far fa-user"></i>
                  <span>{{ __('website.quote.client') }}</span>
                  <strong>{{ $quote->client_name }}</strong>
                </div>
                <div>
                  <i class="fas fa-dollar-sign"></i>
                  <span>{{ __('website.quote.budget_selected') }}</span>
                  <strong>{{ $quote->budget_label }}</strong>
                </div>
                <div>
                  <i class="far fa-calendar-alt"></i>
                  <span>{{ __('website.quote.timeline') }}</span>
                  <strong>{{ $quote->timeline_label }}</strong>
                </div>
              </div>
            </div>
          </div>
          <div class="tcw-quote-result-note">
            <i class="fas fa-info-circle"></i>
            <span>{{ __('website.quote.estimate_notice') }}</span>
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection
