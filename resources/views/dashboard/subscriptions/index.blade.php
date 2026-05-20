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
            <td>{{ $subscription->offer?->title ?? 'Custom Offer' }}</td>
            <td>{{ $subscription->order?->reference ?? '-' }}</td>
            <td>{{ $subscription->currency }} {{ number_format($subscription->amount) }}</td>
            <td>{{ ucfirst(str_replace('_', ' ', $subscription->billing_cycle)) }}</td>
            <td><span class="admin-status-pill {{ $subscription->status === 'active' ? 'is-active' : 'is-inactive' }}">{{ ucfirst(str_replace('_', ' ', $subscription->status)) }}</span></td>
            <td>{{ optional($subscription->starts_at)->format('d M, Y') ?: '-' }}</td>
            <td>{{ optional($subscription->renews_at)->format('d M, Y') ?: '-' }}</td>
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
