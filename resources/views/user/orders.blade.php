@extends('layouts.website')

@section('title', 'Orders')
@section('hide_global_faqs', '1')

@push('css')
  <style>.tcw-site-header,.cs-preloader,.tcw-footer,.tcw-floating-contact,.tcw-support-chat{display:none!important}</style>
@endpush

@section('content')
@php($activeClientNav = 'orders')
@php($clientHeaderTitle = 'Orders')
@php($clientHeaderSubtitle = 'Track your offer purchases and payment status.')
<main class="tcw-client-dashboard tcw-premium-client-dashboard">
  @include('user.partials.client-sidebar')
  <section class="tcw-client-main">
    @include('user.partials.client-header')
    <section class="tcw-client-panel">
      <div class="tcw-client-panel-head">
        <h2>Orders</h2>
        <a href="{{ route('website.offers') }}">New order</a>
      </div>
      <div class="tcw-client-table-wrap">
        <table>
          <thead><tr><th>Reference</th><th>Offer</th><th>Amount</th><th>Payment</th><th>Status</th><th>Date</th></tr></thead>
          <tbody>
            @forelse($orders as $order)
              <tr>
                <td><strong>{{ $order->reference }}</strong></td>
                <td>{{ $order->offer?->title }}</td>
                <td>{{ $order->amount_label }}</td>
                <td>{{ ucfirst($order->payment_status) }}</td>
                <td><span class="tcw-client-status is-{{ $order->status }}">{{ $order->status_label }}</span></td>
                <td>{{ $order->created_at->format('M d, Y') }}</td>
              </tr>
            @empty
              <tr><td colspan="6" class="tcw-client-empty">No orders yet.</td></tr>
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
