@extends('layouts.admin')

@section('header')
  <h2 class="admin-u-001">Orders</h2>
@endsection

@section('content')
<div class="card">
  <div class="admin-u-010">
    <h3 class="admin-u-011">Offer Orders</h3>
  </div>
  <div class="admin-u-012">
    <table>
      <thead>
        <tr>
          <th>Reference</th>
          <th>Client</th>
          <th>Offer</th>
          <th>Amount</th>
          <th>Payment</th>
          <th>Status</th>
          <th>Date</th>
        </tr>
      </thead>
      <tbody>
        @forelse($orders as $order)
          <tr>
            <td><strong>{{ $order->reference }}</strong><small>{{ $order->payment_method }}</small></td>
            <td>{{ $order->user?->name ?? $order->client_name }}<small>{{ $order->client_email }}</small></td>
            <td>{{ $order->offer?->title ?? 'Custom Offer' }}</td>
            <td>{{ $order->amount_label }}</td>
            <td><span class="admin-status-pill {{ $order->payment_status === 'paid' ? 'is-active' : 'is-inactive' }}">{{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}</span></td>
            <td>{{ $order->status_label }}</td>
            <td>{{ $order->created_at->format('d M, Y h:i A') }}</td>
          </tr>
        @empty
          <tr><td colspan="7" class="admin-u-015">No orders found yet.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="admin-u-016">{{ $orders->links() }}</div>
</div>
@endsection
