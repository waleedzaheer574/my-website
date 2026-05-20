@extends('layouts.website')

@section('title', 'Quote Requests')
@section('hide_global_faqs', '1')

@push('css')
  <style>.tcw-site-header,.cs-preloader,.tcw-footer,.tcw-floating-contact,.tcw-support-chat { display:none !important; }</style>
@endpush

@section('content')
  @php($activeClientNav = 'quote-requests')
  @php($clientHeaderTitle = 'Quote Requests')
  @php($clientHeaderSubtitle = 'View and manage all your quote requests in one place.')
  <main class="tcw-client-dashboard tcw-premium-client-dashboard tcw-request-page">
    @include('user.partials.client-sidebar')

    <section class="tcw-client-main">
      @include('user.partials.client-header')
      <header class="tcw-request-header">
        <div class="tcw-page-heading">
          <div>
          <h1>All Quote Requests</h1>
          <p>View and manage all your quote requests in one place.</p>
          </div>
        </div>
        <div class="tcw-request-tools">
          <label><i class="fas fa-search"></i><input type="search" placeholder="Search quote requests..."></label>
          <button type="button"><i class="fas fa-filter"></i> Filter</button>
          <a href="{{ route('website.quote-generator') }}"><i class="fas fa-plus"></i> New Quote</a>
        </div>
      </header>

      <div class="tcw-request-tabs">
        <a class="is-active" href="{{ route('user.quote-requests') }}"><i class="far fa-file-pdf"></i> All Requests ({{ $quoteRequests->total() }})</a>
        <span><i class="far fa-folder"></i> Archived (0)</span>
      </div>

      <section class="tcw-request-table-card">
        <div class="tcw-client-table-wrap">
          <table>
            <thead><tr><th>Reference</th><th>Service</th><th>Estimate</th><th>Status</th><th>Date</th><th>Action</th></tr></thead>
            <tbody>
              @forelse($quoteRequests as $quote)
                <tr>
                  <td><i class="far fa-file-pdf"></i><strong>{{ $quote->reference }}</strong></td>
                  <td><strong>{{ $quote->service_title }}</strong></td>
                  <td>{{ $quote->estimate_label }}</td>
                  <td><span class="tcw-client-status is-{{ $quote->status }}">{{ $quote->status_label }}</span></td>
                  <td>{{ $quote->created_at->format('M d, Y') }}<small>{{ $quote->created_at->format('h:i A') }}</small></td>
                  <td>
                    <div class="tcw-client-action-links">
                      <a href="{{ route('website.quote-generator.proposal', $quote->public_token) }}" title="View quote"><i class="far fa-eye"></i></a>
                      <a href="{{ route('website.quote-generator.download', $quote->public_token) }}" title="Download quote"><i class="fas fa-download"></i></a>
                    </div>
                  </td>
                </tr>
              @empty
                <tr><td colspan="6" class="tcw-client-empty">No quote requests yet.</td></tr>
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
                <time><i class="far fa-calendar-alt"></i> {{ $quote->created_at->format('M d, Y h:i A') }}</time>
              </footer>
              <div class="tcw-client-action-links">
                <a href="{{ route('website.quote-generator.proposal', $quote->public_token) }}"><i class="far fa-eye"></i> View Quote</a>
                <a href="{{ route('website.quote-generator.download', $quote->public_token) }}"><i class="fas fa-download"></i> PDF</a>
              </div>
            </article>
          @empty
            <p>No quote requests yet.</p>
          @endforelse
        </div>

        <footer class="tcw-request-footer"><span>Showing {{ $quoteRequests->firstItem() ?? 0 }} to {{ $quoteRequests->lastItem() ?? 0 }} of {{ $quoteRequests->total() }} results</span><div class="tcw-user-pagination">{{ $quoteRequests->links() }}</div></footer>
      </section>
    </section>
    @include('user.partials.client-mobile-nav')
  </main>
@endsection
@push('js')
  @include('user.partials.client-shell-script')
@endpush
