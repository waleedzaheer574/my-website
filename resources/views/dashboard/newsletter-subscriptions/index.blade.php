@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Newsletter Subscribers</h2>
@endsection

@section('content')
    <div class="card">
        <div class="admin-u-026">
            <div>
                <h3 class="admin-u-027">All Subscribers</h3>
                <p class="admin-u-028">Emails collected from the footer Subscribe Us form.</p>
            </div>
            <a href="{{ route('newsletter-subscriptions.download') }}" class="btn btn-primary">Download Excel Sheet</a>
        </div>

        <div class="admin-u-012">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email</th>
                        <th>Source Page</th>
                        <th>Subscribed At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($subscriptions as $subscription)
                        <tr>
                            <td>{{ $subscription->id }}</td>
                            <td><strong>{{ $subscription->email }}</strong></td>
                            <td>{{ $subscription->source_url ?: 'N/A' }}</td>
                            <td>{{ optional($subscription->created_at)->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="admin-u-015" colspan="4">No subscribers found yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-u-016">
            {{ $subscriptions->links() }}
        </div>
    </div>
@endsection
