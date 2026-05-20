@extends('layouts.website')

@section('content')
  <main class="tcw-quote-page">
    <section class="tcw-quote-result-section">
      <div class="container">
        <div class="tcw-quote-result-shell wow fadeInUp" data-wow-duration="1s">
          <div class="tcw-quote-result-glow" aria-hidden="true"></div>
          <div class="tcw-quote-result-card">
            <div class="tcw-quote-result-left">
              <span class="tcw-detail-eyebrow">Instant quotation</span>
              <h1>{{ $quote->reference }}</h1>
              <p>Your estimated investment for <strong>{{ $quote->service_title }}</strong> is ready. Download the proposal or review the scope before starting another quote.</p>
              <div class="tcw-quote-actions">
                <a href="{{ route('website.quote-generator.download', $quote->public_token) }}" class="tcw-quote-submit">
                  Download PDF Proposal <i class="fas fa-file-pdf"></i>
                </a>
                <a href="{{ route('website.quote-generator.proposal', $quote->public_token) }}" class="tcw-quote-secondary">View Proposal</a>
                <a href="{{ route('website.quote-generator') }}" class="tcw-quote-secondary">Create Another Quote</a>
              </div>
            </div>

            <div class="tcw-quote-result-panel">
              <div class="tcw-quote-result-panel-top">
                <span>Estimated Investment</span>
                <i class="fas fa-file-invoice-dollar"></i>
              </div>
              <div class="tcw-quote-price">
                <span>Total estimated budget</span>
                <strong>{{ $quote->estimate_label }}</strong>
                <small>Flexible budget based on scope and requirements.</small>
              </div>
              <div class="tcw-quote-result-grid">
                <div>
                  <i class="far fa-user"></i>
                  <span>Client</span>
                  <strong>{{ $quote->client_name }}</strong>
                </div>
                <div>
                  <i class="fas fa-dollar-sign"></i>
                  <span>Budget selected</span>
                  <strong>{{ $quote->budget_label }}</strong>
                </div>
                <div>
                  <i class="far fa-calendar-alt"></i>
                  <span>Timeline</span>
                  <strong>{{ $quote->timeline_label }}</strong>
                </div>
              </div>
            </div>
          </div>
          <div class="tcw-quote-result-note">
            <i class="fas fa-info-circle"></i>
            <span>This is an estimated budget. The final proposal may vary based on detailed discussion and project requirements.</span>
          </div>
        </div>
      </div>
    </section>
  </main>
@endsection
