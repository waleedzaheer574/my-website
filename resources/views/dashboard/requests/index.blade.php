@extends('layouts.admin')

@section('title', 'Service Requests')
@section('body_class', 'admin-dashboard-theme admin-requests-theme')
@section('header')
    <h2 class="admin-u-001">Service Requests</h2>
@endsection

@section('content')
    <section class="admin-requests-shell">
        <div class="admin-requests-head">
            <div>
                <h3>All Incoming Requests</h3>
                <p>All requests submitted through the website forms and AI receptionist calls will appear here.</p>
            </div>
            <div class="admin-requests-total">
                <span>Total: {{ $serviceRequests->total() }}</span>
                <i aria-hidden="true"></i>
            </div>
        </div>

        <div class="admin-requests-table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Company</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Country</th>
                        <th>Service</th>
                        <th>Source</th>
                        <th>Budget</th>
                        <th>Website</th>
                        <th>Submitted</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($serviceRequests as $request)
                        <tr>
                            <td>
                                <span class="admin-request-person">
                                    <b>{{ str($request->full_name)->explode(' ')->map(fn ($part) => str($part)->substr(0, 1))->take(2)->implode('') }}</b>
                                    {{ $request->full_name }}
                                </span>
                            </td>
                            <td>{{ $request->company_name }}</td>
                            <td>
                                @if($request->company_email)
                                    <a href="mailto:{{ $request->company_email }}">
                                        {{ $request->company_email }}
                                    </a>
                                @else
                                    {{ __('website.common.not_available') }}
                                @endif
                            </td>
                            <td>{{ $request->phone_no ?: __('website.common.not_available') }}</td>
                            <td>{{ $request->country ?: __('website.common.not_available') }}</td>
                            <td>{{ $request->service_label }}</td>
                            <td>{{ __('website.client.source_labels.'.($request->source === 'ai_call' ? 'ai_call' : 'website')) }}</td>
                            <td>{{ $request->budget ?: __('website.common.not_available') }}</td>
                            <td>
                                @if($request->company_website)
                                    <a href="{{ $request->company_website }}" target="_blank" rel="noopener noreferrer">
                                        {{ str($request->company_website)->replace(['https://', 'http://'], '')->trim('/') }}
                                    </a>
                                @else
                                    {{ __('website.common.not_available') }}
                                @endif
                            </td>
                            <td>
                                <span class="admin-request-date">
                                    {{ $request->created_at->locale(app()->getLocale())->translatedFormat('d M, Y') }}
                                    <small>{{ $request->created_at->locale(app()->getLocale())->translatedFormat('h:i A') }}</small>
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('requests.status.update', $request) }}" method="POST" class="admin-status-form is-{{ $request->status }}">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()">
                                        @foreach($statuses as $value => $label)
                                            <option value="{{ $value }}" @selected($request->status === $value)>{{ __('website.client.status_labels.'.$value) }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td>
                                <div class="admin-request-actions">
                                    @if($request->company_email)
                                        <a href="mailto:{{ $request->company_email }}" aria-label="Email {{ $request->full_name }}">@</a>
                                    @endif
                                    <a href="tel:{{ $request->phone_no }}" aria-label="Call {{ $request->full_name }}">+</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="admin-u-015" colspan="12">No service requests found yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-requests-mobile-list">
            @forelse($serviceRequests as $request)
                <article>
                    <header>
                        <b>{{ str($request->full_name)->explode(' ')->map(fn ($part) => str($part)->substr(0, 1))->take(2)->implode('') }}</b>
                        <div>
                            <strong>{{ $request->full_name }}</strong>
                            <span>{{ $request->company_name }}</span>
                        </div>
                        <form action="{{ route('requests.status.update', $request) }}" method="POST" class="admin-status-form is-{{ $request->status }}">
                            @csrf
                            @method('PATCH')
                            <select name="status" onchange="this.form.submit()">
                                @foreach($statuses as $value => $label)
                                    <option value="{{ $value }}" @selected($request->status === $value)>{{ __('website.client.status_labels.'.$value) }}</option>
                                @endforeach
                            </select>
                        </form>
                    </header>
                    <p>{{ $request->service_label }} · {{ __('website.client.source_labels.'.($request->source === 'ai_call' ? 'ai_call' : 'website')) }}{{ $request->budget ? ' · '.$request->budget : '' }}</p>
                    @if($request->company_website)
                        <a href="{{ $request->company_website }}" target="_blank" rel="noopener noreferrer">
                            {{ str($request->company_website)->replace(['https://', 'http://'], '')->trim('/') }}
                        </a>
                    @endif
                    <footer>
                        <span>{{ $request->created_at->locale(app()->getLocale())->translatedFormat('d M, Y') }}</span>
                        <span>{{ $request->created_at->locale(app()->getLocale())->translatedFormat('h:i A') }}</span>
                    </footer>
                </article>
            @empty
                <p>No service requests found yet.</p>
            @endforelse
        </div>

        @if($serviceRequests->hasPages())
            <div class="admin-requests-pagination admin-u-016">
                {{ $serviceRequests->links() }}
            </div>
        @endif
    </section>
@endsection
