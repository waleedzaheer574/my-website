@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Portfolio Management</h2>
@endsection

@section('content')
    <div class="card">
        <div class="admin-u-026">
            <div>
                <h3 class="admin-u-027">All Portfolio Items</h3>
                <p class="admin-u-028">These items appear on the portfolio page and featured home slider.</p>
            </div>
            <a href="{{ route('portfolios.create') }}" class="btn btn-primary">Add New Portfolio</a>
        </div>

        <div class="admin-u-012">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($portfolios as $portfolio)
                        <tr>
                            <td>{{ $portfolio->id }}</td>
                            <td>
                                <img class="admin-u-076" src="{{ asset($portfolio->image) }}" alt="{{ $portfolio->localized('title') }}">
                            </td>
                            <td>
                                <strong>{{ $portfolio->localized('title') }}</strong>
                                @if($portfolio->is_featured)
                                    <div class="admin-u-050">Featured on Home</div>
                                @endif
                            </td>
                            <td>{{ $portfolio->localized('category') ?: __('website.common.not_available') }}</td>
                            <td>
                                <span class="admin-status-pill {{ $portfolio->is_active ? 'is-active' : 'is-inactive' }}">
                                    {{ $portfolio->is_active ? __('website.client.status_labels.active') : __('website.client.status_labels.hidden') }}
                                </span>
                            </td>
                            <td>{{ $portfolio->sort_order }}</td>
                            <td>
                                <div class="admin-u-031">
                                    <a class="admin-u-082" href="{{ route('website.portfolio-details.show', $portfolio->slug) }}" target="_blank">View</a>
                                    <a class="admin-u-033" href="{{ route('portfolios.edit', $portfolio) }}">Edit</a>
                                    <form action="{{ route('portfolios.destroy', $portfolio) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-u-034" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="admin-u-015" colspan="7">No portfolio items found yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-u-016">
            {{ $portfolios->links() }}
        </div>
    </div>
@endsection
