@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">FAQ Management</h2>
@endsection

@section('content')
    <div class="card">
        <div class="admin-u-026">
            <div>
                <h3 class="admin-u-027">All FAQs</h3>
                <p class="admin-u-028">Add page-specific questions from one place.</p>
            </div>
            <a href="{{ route('faqs.create') }}" class="btn btn-primary">Add New FAQ</a>
        </div>

        <div class="admin-u-012">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Page</th>
                        <th>Question</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($faqs as $faq)
                        <tr>
                            <td>{{ $faq->id }}</td>
                            <td>{{ \App\Models\Faq::pageLabel($faq->page_key) }}</td>
                            <td>
                                <strong>{{ $faq->question }}</strong>
                                <div class="admin-u-040">{{ \Illuminate\Support\Str::limit(strip_tags($faq->answer), 90) }}</div>
                            </td>
                            <td>
                                <span class="admin-status-pill {{ $faq->is_active ? 'is-active' : 'is-inactive' }}">
                                    {{ $faq->is_active ? 'Active' : 'Hidden' }}
                                </span>
                            </td>
                            <td>{{ $faq->sort_order }}</td>
                            <td>
                                <div class="admin-u-031">
                                    <a class="admin-u-033" href="{{ route('faqs.edit', $faq) }}">Edit</a>
                                    <form action="{{ route('faqs.destroy', $faq) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-u-034" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="admin-u-015" colspan="6">No FAQs found yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-u-016">
            {{ $faqs->links() }}
        </div>
    </div>
@endsection
