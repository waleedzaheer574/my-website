@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Services Management</h2>
@endsection

@section('content')
    <div class="card">
        <div class="admin-u-010">
            <h3 class="admin-u-011">All Services</h3>
            <a href="{{ route('services.create') }}" class="btn btn-primary">Add New Service</a>
        </div>

        <div class="admin-u-012">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Icon</th>
                        <th>Service Title</th>
                        <th>Service Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($services as $service)
                        <tr>
                            <td>{{ $service->id }}</td>
                            <td>
                                @if($service->icon)
                                    <img class="admin-u-092" src="{{ asset($service->icon) }}" alt="{{ $service->localized('service_title') }}">
                                @else
                                    <span class="admin-u-068">{{ __('website.common.no_image') }}</span>
                                @endif
                            </td>
                            <td>{{ $service->localized('service_title') }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($service->localized('service_description'), 120) }}</td>
                            <td>
                                <div class="admin-u-031">
                                    <a class="admin-u-073" href="{{ route('services.edit', $service->id) }}">Edit</a>
                                    <form action="{{ route('services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-u-014" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="admin-u-015" colspan="5">No services found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-u-016">
            {{ $services->links() }}
        </div>
    </div>
@endsection
