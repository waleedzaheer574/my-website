@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Blogs Management</h2>
@endsection

@section('content')
    <div class="card">
        <div class="admin-u-010">
            <h3 class="admin-u-011">All Blogs</h3>
            <a href="{{ route('blogs.create') }}" class="btn btn-primary">Add New Blog</a>
        </div>

        <div class="admin-u-012">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Status</th>
                        <th>Published</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($blogs as $blog)
                        <tr>
                            <td>{{ $blog->id }}</td>
                            <td>
                                <img class="admin-u-071" src="{{ asset($blog->featured_image) }}" alt="{{ $blog->title }}">
                            </td>
                            <td>{{ $blog->title }}</td>
                            <td>{{ $blog->author_name }}</td>
                            <td>{{ $blog->is_active ? 'Active' : 'Inactive' }}</td>
                            <td>{{ $blog->published_at ? $blog->published_at->format('d M, Y h:i A') : 'Draft' }}</td>
                            <td>
                                <div class="admin-u-013">
                                    <a class="admin-u-072" href="{{ route('blogs.show', $blog->slug) }}">View</a>
                                    <a class="admin-u-073" href="{{ route('blogs.edit', $blog->slug) }}">Edit</a>
                                    <form action="{{ route('blogs.destroy', $blog->slug) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-u-014" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="admin-u-015" colspan="7">No blogs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-u-016">
            {{ $blogs->links() }}
        </div>
    </div>
@endsection
