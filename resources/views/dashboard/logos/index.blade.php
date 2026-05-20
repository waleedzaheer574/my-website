@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Logo Management</h2>
@endsection

@section('content')
    <div class="card">
        <div class="admin-u-010">
            <h3 class="admin-u-011">All Logos</h3>
            <a href="{{ route('logos.create') }}" class="btn btn-primary">Add New Logo</a>
        </div>

        <div class="admin-u-012">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Logo</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logos as $logo)
                        <tr>
                            <td>{{ $logo->id }}</td>
                            <td>
                                <img class="admin-u-081" src="{{ asset('storage/' . $logo->logo) }}" alt="Logo">
                            </td>
                            <td>
                                <div class="admin-u-031">
                                    <a class="admin-u-073" href="{{ route('logos.edit', $logo->id) }}">Edit</a>
                                    <form action="{{ route('logos.destroy', $logo->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-u-014" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="admin-u-015" colspan="3">No logos found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-u-016">
            {{ $logos->links() }}
        </div>
    </div>
@endsection
