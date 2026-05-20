@extends('layouts.website')

@section('title', 'Service Requests')
@section('hide_global_faqs', '1')

@push('css')
  <style>.tcw-site-header,.cs-preloader,.tcw-footer,.tcw-floating-contact,.tcw-support-chat { display:none !important; }</style>
@endpush

@section('content')
  @php($activeClientNav = 'service-requests')
  @php($clientHeaderTitle = 'Service Requests')
  @php($clientHeaderSubtitle = 'View and manage all your service requests in one place.')
  <main class="tcw-client-dashboard tcw-premium-client-dashboard tcw-request-page">
    @include('user.partials.client-sidebar')

    <section class="tcw-client-main">
      @include('user.partials.client-header')
      <header class="tcw-request-header">
        <div class="tcw-page-heading">
          <div>
          <h1>All Service Requests</h1>
          <p>View and manage all your service requests in one place.</p>
          </div>
        </div>
        <div class="tcw-request-tools">
          <label><i class="fas fa-search"></i><input type="search" placeholder="Search service requests..."></label>
          <button type="button"><i class="fas fa-filter"></i> Filter</button>
          <a href="{{ route('website.contact') }}"><i class="fas fa-plus"></i> New Request</a>
        </div>
      </header>

      <div class="tcw-request-tabs">
        <a class="is-active" href="{{ route('user.service-requests') }}"><i class="far fa-file-alt"></i> All Requests ({{ $serviceRequests->total() }})</a>
        <span><i class="far fa-folder"></i> Archived (0)</span>
      </div>

      <section class="tcw-request-table-card">
        <div class="tcw-client-table-wrap">
          <table>
            <thead><tr><th>Reference</th><th>Service</th><th>Company</th><th>Status</th><th>Date</th><th>Action</th></tr></thead>
            <tbody>
              @forelse($serviceRequests as $request)
                <tr>
                  <td><i class="far fa-file-alt"></i><strong>SR-{{ str_pad((string) $request->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                  <td><strong>{{ $request->service_type }}</strong></td>
                  <td>{{ $request->company_name }}</td>
                  <td><span class="tcw-client-status is-{{ $request->status }}">{{ $request->status_label }}</span></td>
                  <td>{{ $request->created_at->format('M d, Y') }}<small>{{ $request->created_at->format('h:i A') }}</small></td>
                  <td><button type="button"><i class="fas fa-ellipsis-h"></i></button></td>
                </tr>
              @empty
                <tr><td colspan="6" class="tcw-client-empty">No service requests yet.</td></tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="tcw-request-mobile-cards">
          @forelse($serviceRequests as $request)
            <article>
              <div>
                <i class="far fa-file-alt"></i>
                <strong>SR-{{ str_pad((string) $request->id, 4, '0', STR_PAD_LEFT) }}</strong>
                <b class="tcw-client-status is-{{ $request->status }}">{{ $request->status_label }}</b>
              </div>
              <h2>{{ $request->service_type }}</h2>
              <p>{{ $request->company_name }}</p>
              <footer><span><i class="far fa-building"></i> {{ $request->company_name }}</span><time><i class="far fa-calendar-alt"></i> {{ $request->created_at->format('M d, Y h:i A') }}</time></footer>
            </article>
          @empty
            <p>No service requests yet.</p>
          @endforelse
        </div>

        <footer class="tcw-request-footer"><span>Showing {{ $serviceRequests->firstItem() ?? 0 }} to {{ $serviceRequests->lastItem() ?? 0 }} of {{ $serviceRequests->total() }} results</span><div class="tcw-user-pagination">{{ $serviceRequests->links() }}</div></footer>
      </section>
    </section>
    @include('user.partials.client-mobile-nav')
  </main>
@endsection
@push('js')
  @include('user.partials.client-shell-script')
@endpush
