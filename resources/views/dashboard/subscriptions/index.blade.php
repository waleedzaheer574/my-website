@extends('layouts.admin')

@section('header')
  <h2 class="admin-u-001">Subscriptions</h2>
@endsection

@section('content')
<div class="card">
  <div class="admin-u-010">
    <h3 class="admin-u-011">Client Subscriptions</h3>
  </div>
  <div class="admin-u-012">
    <table>
      <thead>
        <tr>
          <th>Client</th>
          <th>Offer</th>
          <th>Order</th>
          <th>Amount</th>
          <th>Billing</th>
          <th>Status</th>
          <th>Started</th>
          <th>Renews</th>
        </tr>
      </thead>
      <tbody>
        @forelse($subscriptions as $subscription)
          <tr>
            <td>{{ $subscription->user?->name }}<small>{{ $subscription->user?->email }}</small></td>
            <td>{{ $subscription->offer?->localized('title') ?? __('website.client.offer') }}</td>
            <td>{{ $subscription->order?->reference ?? '-' }}</td>
            <td>{{ $subscription->currency }} {{ number_format($subscription->amount) }}</td>
            <td>{{ __('website.dynamic.billing.'.$subscription->billing_cycle) }}</td>
            <td><span class="admin-status-pill {{ $subscription->status === 'active' ? 'is-active' : 'is-inactive' }}">{{ __('website.client.status_labels.'.$subscription->status) }}</span></td>
            <td>{{ $subscription->starts_at?->locale(app()->getLocale())->translatedFormat('d M, Y') ?: '-' }}</td>
            <td>{{ $subscription->renews_at?->locale(app()->getLocale())->translatedFormat('d M, Y') ?: '-' }}</td>
          </tr>
        @empty
          <tr><td colspan="8" class="admin-u-015">No subscriptions found yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="admin-u-016">{{ $subscriptions->links() }}</div>
</div>
@endsection
