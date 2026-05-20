@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Industries Management</h2>
@endsection

@section('content')
    <div class="card">
        <div class="admin-u-026">
            <div>
                <h3 class="admin-u-027">All Industries</h3>
                <p class="admin-u-028">These industries appear on the public industries page.</p>
            </div>
            <a href="{{ route('industries.create') }}" class="btn btn-primary">Add New Industry</a>
        </div>

        <div class="admin-u-012">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Icon</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Result</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($industries as $industry)
                        <tr>
                            <td>{{ $industry->id }}</td>
                            <td>
                                @if($industry->icon)
                                    <img class="admin-u-078" src="{{ asset($industry->icon) }}" alt="{{ $industry->title }}">
                                @else
                                    <span class="admin-u-041">-</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $industry->title }}</strong>
                                <div class="admin-u-030">{{ \Illuminate\Support\Str::limit($industry->description, 70) }}</div>
                            </td>
                            <td>{{ $industry->category ?: 'N/A' }}</td>
                            <td>{{ $industry->result ?: 'N/A' }}</td>
                            <td>
                                <span class="admin-status-pill {{ $industry->is_active ? 'is-active' : 'is-inactive' }}">
                                    {{ $industry->is_active ? 'Active' : 'Hidden' }}
                                </span>
                            </td>
                            <td>{{ $industry->sort_order }}</td>
                            <td>
                                <div class="admin-u-031">
                                    <a class="admin-u-032" href="{{ url('/industries') }}" target="_blank">View</a>
                                    <a class="admin-u-033" href="{{ route('industries.edit', $industry) }}">Edit</a>
                                    <form action="{{ route('industries.destroy', $industry) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-u-034" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="admin-u-015" colspan="7">No industries found yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-u-016">
            {{ $industries->links() }}
        </div>
    </div>
@endsection
