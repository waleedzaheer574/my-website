@extends('layouts.website')

@section('title', __('website.client.quote_requests'))
@section('hide_global_faqs', '1')

@push('css')
  <style>.tcw-site-header,.cs-preloader,.tcw-footer,.tcw-floating-contact,.tcw-support-chat { display:none !important; }</style>
@endpush

@section('content')
  @php($activeClientNav = 'quote-requests')
  @php($clientHeaderTitle = __('website.client.quote_requests'))
  @php($clientHeaderSubtitle = __('website.client.quote_subtitle'))
  <main class="tcw-client-dashboard tcw-premium-client-dashboard tcw-request-page">
    @include('user.partials.client-sidebar')

    <section class="tcw-client-main">
      @include('user.partials.client-header')
      <header class="tcw-request-header">
        <div class="tcw-page-heading">
          <div>
          <h1>{{ __('website.client.all_quote_requests') }}</h1>
          <p>{{ __('website.client.quote_subtitle') }}</p>
          </div>
        </div>
        <div class="tcw-request-tools">
          <label><i class="fas fa-search"></i><input type="search" placeholder="{{ __('website.client.search_quote') }}"></label>
          <button type="button"><i class="fas fa-filter"></i> {{ __('website.client.filter') }}</button>
          <a href="{{ route('website.quote-generator') }}"><i class="fas fa-plus"></i> {{ __('website.client.new_quote') }}</a>
        </div>
      </header>

      <div class="tcw-request-tabs">
        <a class="is-active" href="{{ route('user.quote-requests') }}"><i class="far fa-file-pdf"></i> {{ __('website.client.all_requests') }} ({{ $quoteRequests->total() }})</a>
        <span><i class="far fa-folder"></i> {{ __('website.client.archived') }} (0)</span>
      </div>

      <section class="tcw-request-table-card">
        <div class="tcw-client-table-wrap">
          <table>
            <thead><tr><th>{{ __('website.client.reference') }}</th><th>{{ __('website.client.service') }}</th><th>{{ __('website.client.estimate') }}</th><th>{{ __('website.client.status') }}</th><th>{{ __('website.client.date') }}</th><th>{{ __('website.client.action') }}</th></tr></thead>
            <tbody>
              @forelse($quoteRequests as $quote)
                <tr>
                  <td><i class="far fa-file-pdf"></i><strong>{{ $quote->reference }}</strong></td>
                  <td><strong>{{ $quote->service_title }}</strong></td>
                  <td>{{ $quote->estimate_label }}</td>
                  <td><span class="tcw-client-status is-{{ $quote->status }}">{{ $quote->status_label }}</span></td>
                  <td>{{ $quote->created_at->locale(app()->getLocale())->translatedFormat('M d, Y') }}<small>{{ $quote->created_at->format('h:i A') }}</small></td>
                  <td>
                    <div class="tcw-client-action-links">
                      <a href="{{ route('website.quote-generator.proposal', $quote->public_token) }}" title="{{ __('website.client.view_quote') }}"><i class="far fa-eye"></i></a>
                      <a href="{{ route('website.quote-generator.download', $quote->public_token) }}" title="{{ __('website.client.download_quote') }}"><i class="fas fa-download"></i></a>
                    </div>
                  </td>
                </tr>
              @empty
                <tr><td colspan="6" class="tcw-client-empty">{{ __('website.client.no_quote_requests') }}</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="tcw-request-mobile-cards">
          @forelse($quoteRequests as $quote)
            <article>
              <div>
                <i class="far fa-file-pdf"></i>
                <strong>{{ $quote->reference }}</strong>
                <b class="tcw-client-status is-{{ $quote->status }}">{{ $quote->status_label }}</b>
              </div>
              <h2>{{ $quote->service_title }}</h2>
              <p>{{ $quote->estimate_label }}</p>
              <footer>
                <span><i class="far fa-eye"></i> {{ $quote->estimate_label }}</span>
                <time><i class="far fa-calendar-alt"></i> {{ $quote->created_at->locale(app()->getLocale())->translatedFormat('M d, Y') }} {{ $quote->created_at->format('h:i A') }}</time>
              </footer>
              <div class="tcw-client-action-links">
                <a href="{{ route('website.quote-generator.proposal', $quote->public_token) }}"><i class="far fa-eye"></i> {{ __('website.client.view_quote') }}</a>
                <a href="{{ route('website.quote-generator.download', $quote->public_token) }}"><i class="fas fa-download"></i> PDF</a>
              </div>
            </article>
          @empty
            <p>{{ __('website.client.no_quote_requests') }}</p>
          @endforelse
        </div>

        <footer class="tcw-request-footer"><span>{{ __('website.client.showing', ['from' => $quoteRequests->firstItem() ?? 0, 'to' => $quoteRequests->lastItem() ?? 0, 'total' => $quoteRequests->total()]) }}</span><div class="tcw-user-pagination">{{ $quoteRequests->links() }}</div></footer>
      </section>
    </section>
    @include('user.partials.client-mobile-nav')
  </main>
@endsection
@push('js')
  @include('user.partials.client-shell-script')
@endpush
