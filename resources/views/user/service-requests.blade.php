@extends('layouts.website')

@section('title', __('website.client.service_requests'))
@section('hide_global_faqs', '1')

@push('css')
  <style>.tcw-site-header,.cs-preloader,.tcw-footer,.tcw-floating-contact,.tcw-support-chat { display:none !important; }</style>
@endpush

@section('content')
  @php($activeClientNav = 'service-requests')
  @php($clientHeaderTitle = __('website.client.service_requests'))
  @php($clientHeaderSubtitle = __('website.client.service_subtitle'))
  <main class="tcw-client-dashboard tcw-premium-client-dashboard tcw-request-page">
    @include('user.partials.client-sidebar')

    <section class="tcw-client-main">
      @include('user.partials.client-header')
      <header class="tcw-request-header">
        <div class="tcw-page-heading">
          <div>
          <h1>{{ __('website.client.all_service_requests') }}</h1>
          <p>{{ __('website.client.service_subtitle') }}</p>
          </div>
        </div>
        <div class="tcw-request-tools">
          <label><i class="fas fa-search"></i><input type="search" placeholder="{{ __('website.client.search_service') }}"></label>
          <button type="button"><i class="fas fa-filter"></i> {{ __('website.client.filter') }}</button>
          <a href="{{ route('website.contact') }}"><i class="fas fa-plus"></i> {{ __('website.client.new_request') }}</a>
        </div>
      </header>

      <div class="tcw-request-tabs">
        <a class="is-active" href="{{ route('user.service-requests') }}"><i class="far fa-file-alt"></i> {{ __('website.client.all_requests') }} ({{ $serviceRequests->total() }})</a>
        <span><i class="far fa-folder"></i> {{ __('website.client.archived') }} (0)</span>
      </div>

      <section class="tcw-request-table-card">
        <div class="tcw-client-table-wrap">
          <table>
            <thead><tr><th>{{ __('website.client.reference') }}</th><th>{{ __('website.client.service') }}</th><th>{{ __('website.client.company') }}</th><th>{{ __('website.client.status') }}</th><th>{{ __('website.client.date') }}</th><th>{{ __('website.client.action') }}</th></tr></thead>
            <tbody>
              @forelse($serviceRequests as $request)
                <tr>
                  <td><i class="far fa-file-alt"></i><strong>SR-{{ str_pad((string) $request->id, 4, '0', STR_PAD_LEFT) }}</strong></td>
                  <td><strong>{{ $request->service_type }}</strong></td>
                  <td>{{ $request->company_name }}</td>
                  <td><span class="tcw-client-status is-{{ $request->status }}">{{ $request->status_label }}</span></td>
                  <td>{{ $request->created_at->locale(app()->getLocale())->translatedFormat('M d, Y') }}<small>{{ $request->created_at->format('h:i A') }}</small></td>
                  <td><button type="button"><i class="fas fa-ellipsis-h"></i></button></td>
                </tr>
              @empty
                <tr><td colspan="6" class="tcw-client-empty">{{ __('website.client.no_service_requests') }}</td></tr>
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
              <footer><span><i class="far fa-building"></i> {{ $request->company_name }}</span><time><i class="far fa-calendar-alt"></i> {{ $request->created_at->locale(app()->getLocale())->translatedFormat('M d, Y') }} {{ $request->created_at->format('h:i A') }}</time></footer>
            </article>
          @empty
            <p>{{ __('website.client.no_service_requests') }}</p>
          @endforelse
        </div>

        <footer class="tcw-request-footer"><span>{{ __('website.client.showing', ['from' => $serviceRequests->firstItem() ?? 0, 'to' => $serviceRequests->lastItem() ?? 0, 'total' => $serviceRequests->total()]) }}</span><div class="tcw-user-pagination">{{ $serviceRequests->links() }}</div></footer>
      </section>
    </section>
    @include('user.partials.client-mobile-nav')
  </main>
@endsection
@push('js')
  @include('user.partials.client-shell-script')
@endpush
