@extends('layouts.admin')

@section('header')
  <h2 class="admin-u-001">Offers Management</h2>
@endsection

@section('content')
<div class="card">
  <div class="admin-u-010">
    <h3 class="admin-u-011">All Offers</h3>
    <a href="{{ route('offers.admin.create') }}" class="btn btn-primary">Add Offer</a>
  </div>
  <div class="admin-u-012">
    <table>
      <thead><tr><th>ID</th><th>Offer</th><th>Price</th><th>Billing</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        @forelse($offers as $offer)
          <tr>
            <td>{{ $offer->id }}</td>
            <td><strong>{{ $offer->localized('title') }}</strong><small>{{ $offer->localized('category') }}</small></td>
            <td>{{ $offer->price_label }}</td>
            <td>{{ $offer->billing_label }}</td>
            <td>{{ $offer->is_active ? __('website.client.status_labels.active') : __('website.client.status_labels.hidden') }}</td>
            <td>
              <div class="admin-u-031">
                <a class="admin-u-073" href="{{ route('offers.admin.edit', $offer) }}">Edit</a>
                <form action="{{ route('offers.admin.destroy', $offer) }}" method="POST" onsubmit="return confirm('Delete this offer?')">
                  @csrf @method('DELETE')
                  <button class="admin-u-014" type="submit">Delete</button>
                </form>
              </div>
            </td>
          </tr>
        @empty
          <tr><td colspan="6" class="admin-u-015">No offers found.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>
  <div class="admin-u-016">{{ $offers->links() }}</div>
</div>
@endsection
