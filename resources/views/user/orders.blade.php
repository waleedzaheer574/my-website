@extends('layouts.website')

@section('title', __('website.client.orders'))
@section('hide_global_faqs', '1')

@push('css')
  <style>.tcw-site-header,.cs-preloader,.tcw-footer,.tcw-floating-contact,.tcw-support-chat{display:none!important}</style>
@endpush

@section('content')
@php($activeClientNav = 'orders')
@php($clientHeaderTitle = __('website.client.orders'))
@php($clientHeaderSubtitle = __('website.client.orders_subtitle'))
<main class="tcw-client-dashboard tcw-premium-client-dashboard">
  @include('user.partials.client-sidebar')
  <section class="tcw-client-main">
    @include('user.partials.client-header')
    <section class="tcw-client-panel">
      <div class="tcw-client-panel-head">
        <h2>{{ __('website.client.orders') }}</h2>
        <a href="{{ route('website.offers') }}">{{ __('website.client.new_order') }}</a>
      </div>
      <div class="tcw-client-table-wrap">
        <table>
          <thead><tr><th>{{ __('website.client.reference') }}</th><th>{{ __('website.client.offer') }}</th><th>{{ __('website.client.amount') }}</th><th>{{ __('website.client.payment') }}</th><th>{{ __('website.client.status') }}</th><th>{{ __('website.client.date') }}</th></tr></thead>
          <tbody>
            @forelse($orders as $order)
              @php($paymentStatusKey = 'website.client.status_labels.'.$order->payment_status)
              <tr>
                <td><strong>{{ $order->reference }}</strong></td>
                <td>{{ $order->offer?->localized('title') }}</td>
                <td>{{ $order->amount_label }}</td>
                <td>{{ __($paymentStatusKey) !== $paymentStatusKey ? __($paymentStatusKey) : ucfirst(str_replace('_', ' ', $order->payment_status)) }}</td>
                <td><span class="tcw-client-status is-{{ $order->status }}">{{ $order->status_label }}</span></td>
                <td>{{ $order->created_at->locale(app()->getLocale())->translatedFormat('M d, Y') }}</td>
              </tr>
            @empty
              <tr><td colspan="6" class="tcw-client-empty">{{ __('website.client.no_orders') }}</td></tr>
            @endforelse
          </tbody>
        </table>
      </div>
      {{ $orders->links() }}
    </section>
  </section>
  @include('user.partials.client-mobile-nav')
</main>
@endsection

@push('js')
  @include('user.partials.client-shell-script')
@endpush
