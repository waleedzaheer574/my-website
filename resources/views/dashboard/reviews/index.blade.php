@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Client Reviews</h2>
@endsection

@section('content')
    <div class="card">
        <div class="admin-u-026">
            <div>
                <h3 class="admin-u-027">All Client Reviews</h3>
                <p class="admin-u-028">These text reviews appear in the website client feedback slider.</p>
            </div>
            <a href="{{ route('reviews.create') }}" class="btn btn-primary">Add Review</a>
        </div>

        <div class="admin-u-012">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Review</th>
                        <th>Rating</th>
                        <th>Badge</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                        <tr>
                            <td>{{ $review->id }}</td>
                            <td>
                                <strong>{{ $review->client_name }}</strong>
                                @if($review->localized('designation'))
                                    <div class="admin-u-040">{{ $review->localized('designation') }}</div>
                                @endif
                            </td>
                            <td>{{ \Illuminate\Support\Str::limit($review->localized('review_text'), 120) }}</td>
                            <td>{{ $review->rating ?? 5 }}/5</td>
                            <td>{{ $review->localized('badge') ?: __('website.common.slider') }}</td>
                            <td>
                                <span class="admin-status-pill {{ $review->is_active ? 'is-active' : 'is-inactive' }}">
                                    {{ $review->is_active ? __('website.client.status_labels.active') : __('website.client.status_labels.hidden') }}
                                </span>
                            </td>
                            <td>{{ $review->sort_order }}</td>
                            <td>
                                <div class="admin-u-031">
                                    <a class="admin-u-033" href="{{ route('reviews.edit', $review) }}">Edit</a>
                                    <form action="{{ route('reviews.destroy', $review) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-u-034" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="admin-u-015" colspan="8">No client reviews found yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-u-016">
            {{ $reviews->links() }}
        </div>
    </div>
@endsection
