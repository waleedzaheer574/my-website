@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Why Nexa Management</h2>
@endsection

@section('content')
    <div class="card">
        <div class="admin-u-026">
            <div>
                <h3 class="admin-u-027">Home Page Why Nexa Items</h3>
                <p class="admin-u-028">Maximum 3 items can be added.</p>
            </div>
            @if($canCreate)
                <a href="{{ route('why-nexa.create') }}" class="btn btn-primary">Add New Item</a>
            @else
                <span class="btn admin-u-070">Limit Reached (3)</span>
            @endif
        </div>

        <div class="admin-u-012">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Icon</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($whyNexas as $whyNexa)
                        <tr>
                            <td>{{ $whyNexa->id }}</td>
                            <td>
                                @if($whyNexa->icon)
                                    <img class="admin-u-078" src="{{ asset($whyNexa->icon) }}" alt="{{ $whyNexa->title }}">
                                @else
                                    <span class="admin-u-041">-</span>
                                @endif
                            </td>
                            <td><strong>{{ $whyNexa->title }}</strong></td>
                            <td>{{ \Illuminate\Support\Str::limit($whyNexa->description, 90) }}</td>
                            <td>
                                <span class="admin-status-pill {{ $whyNexa->is_active ? 'is-active' : 'is-inactive' }}">
                                    {{ $whyNexa->is_active ? 'Active' : 'Hidden' }}
                                </span>
                            </td>
                            <td>{{ $whyNexa->sort_order }}</td>
                            <td>
                                <div class="admin-u-031">
                                    <a class="admin-u-033" href="{{ route('why-nexa.edit', $whyNexa) }}">Edit</a>
                                    <form action="{{ route('why-nexa.destroy', $whyNexa) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-u-034" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="admin-u-015" colspan="7">No Why Nexa items found yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-u-016">
            {{ $whyNexas->links() }}
        </div>
    </div>
@endsection
