@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Service Details</h2>
@endsection

@section('content')
    <div class="card">
        <div class="admin-u-010">
            <h3 class="admin-u-011">All Service Details</h3>
            <a href="{{ route('service-details.create') }}" class="btn btn-primary">Add New Detail</a>
        </div>

        <div class="admin-u-012">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Service</th>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($serviceDetails as $detail)
                        <tr>
                            <td>{{ $detail->id }}</td>
                            <td>{{ $detail->service?->localized('service_title') ?? __('website.common.not_available') }}</td>
                            <td>{{ trim(($detail->localized('title_prefix') ?? '') . ' ' . ($detail->localized('title_highlight') ?? '')) }}</td>
                            <td>{{ $detail->slug }}</td>
                            <td>
                                <div class="admin-u-031">
                                    <a class="admin-u-072" href="{{ route('service-details.show', $detail->id) }}">View</a>
                                    <a class="admin-u-073" href="{{ route('service-details.edit', $detail->id) }}">Edit</a>
                                    <form action="{{ route('service-details.destroy', $detail->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-u-014" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="admin-u-015" colspan="5">No service details found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-u-016">
            {{ $serviceDetails->links() }}
        </div>
    </div>
@endsection
