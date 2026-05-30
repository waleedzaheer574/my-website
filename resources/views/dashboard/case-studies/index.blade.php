@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Case Studies Management</h2>
@endsection

@section('content')
    <div class="card">
        <div class="admin-u-026">
            <div>
                <h3 class="admin-u-027">All Case Studies</h3>
                <p class="admin-u-028">These cards appear on the public case studies page.</p>
            </div>
            <a href="{{ route('case-studies.create') }}" class="btn btn-primary">Add New Case Study</a>
        </div>

        <div class="admin-u-012">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Image</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Result</th>
                        <th>Status</th>
                        <th>Order</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($caseStudies as $caseStudy)
                        <tr>
                            <td>{{ $caseStudy->id }}</td>
                            <td>
                                @if($caseStudy->image)
                                    <img class="admin-u-076" src="{{ asset($caseStudy->image) }}" alt="{{ $caseStudy->localized('title') }}">
                                @else
                                    <span class="admin-u-029">-</span>
                                @endif
                            </td>
                            <td>
                                <strong>{{ $caseStudy->localized('title') }}</strong>
                                <div class="admin-u-030">{{ \Illuminate\Support\Str::limit($caseStudy->localized('summary'), 70) }}</div>
                            </td>
                            <td>{{ $caseStudy->localized('category') ?: __('website.common.not_available') }}</td>
                            <td>{{ $caseStudy->localized('result') ?: __('website.common.not_available') }}</td>
                            <td>
                                <span class="admin-status-pill {{ $caseStudy->is_active ? 'is-active' : 'is-inactive' }}">
                                    {{ $caseStudy->is_active ? __('website.client.status_labels.active') : __('website.client.status_labels.hidden') }}
                                </span>
                            </td>
                            <td>{{ $caseStudy->sort_order }}</td>
                            <td>
                                <div class="admin-u-031">
                                    <a class="admin-u-032" href="{{ route('website.case-studies') }}" target="_blank">View</a>
                                    <a class="admin-u-033" href="{{ route('case-studies.edit', $caseStudy) }}">Edit</a>
                                    <form action="{{ route('case-studies.destroy', $caseStudy) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="admin-u-034" type="submit">Delete</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="admin-u-015" colspan="8">No case studies found yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-u-016">
            {{ $caseStudies->links() }}
        </div>
    </div>
@endsection
