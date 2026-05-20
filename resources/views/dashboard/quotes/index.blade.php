@extends('layouts.admin')

@section('title', 'Quote Requests')
@section('body_class', 'admin-dashboard-theme admin-quotes-theme')
@section('header')
    <h2 class="admin-u-001">Quote Requests</h2>
@endsection

@section('content')
    <section class="admin-quotes-shell">
        <header>
            <div>
                <h3>Dynamic Quote Generator</h3>
                <p>Instant quote submissions from the website appear here.</p>
            </div>
            <b>Total: {{ $quotes->total() }}</b>
        </header>

        <div class="admin-quotes-table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Client</th>
                        <th>Service</th>
                        <th>Estimate</th>
                        <th>Status</th>
                        <th>Submitted</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($quotes as $quote)
                        <tr>
                            <td>{{ $quote->reference }}</td>
                            <td>
                                <span class="admin-quote-client">
                                    <b>{{ str($quote->client_name)->explode(' ')->map(fn ($part) => str($part)->substr(0, 1))->take(2)->implode('') }}</b>
                                    <span>
                                        <strong>{{ $quote->client_name }}</strong>
                                        <a href="mailto:{{ $quote->client_email }}">{{ $quote->client_email }}</a>
                                    </span>
                                </span>
                            </td>
                            <td>{{ $quote->service_title }}</td>
                            <td>{{ $quote->estimate_label }}</td>
                            <td>
                                <form action="{{ route('quotes.status.update', $quote) }}" method="POST" class="admin-status-form is-{{ $quote->status }}">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()">
                                        @foreach($statuses as $value => $label)
                                            <option value="{{ $value }}" @selected($quote->status === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </td>
                            <td>
                                <span class="admin-request-date">
                                    {{ $quote->created_at->format('d M, Y') }}
                                    <small>{{ $quote->created_at->format('h:i A') }}</small>
                                </span>
                            </td>
                            <td>
                                <div class="admin-quote-actions">
                                    <a href="{{ route('quotes.show', $quote) }}">View</a>
                                    <a href="{{ route('website.quote-generator.download', $quote->public_token) }}">PDF</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7">No quote requests found yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-quotes-mobile-list">
            @forelse($quotes as $quote)
                <article>
                    <header>
                        <strong>{{ $quote->reference }}</strong>
                    </header>
                    <dl>
                        <dt>Client</dt>
                        <dd class="admin-quote-client">
                            <b>{{ str($quote->client_name)->explode(' ')->map(fn ($part) => str($part)->substr(0, 1))->take(2)->implode('') }}</b>
                            <span>{{ $quote->client_name }}<small>{{ $quote->client_email }}</small></span>
                        </dd>
                        <dt>Service</dt>
                        <dd>{{ $quote->service_title }}</dd>
                        <dt>Estimate</dt>
                        <dd>{{ $quote->estimate_label }}</dd>
                        <dt>Status</dt>
                        <dd>
                            <form action="{{ route('quotes.status.update', $quote) }}" method="POST" class="admin-status-form is-{{ $quote->status }}">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()">
                                    @foreach($statuses as $value => $label)
                                        <option value="{{ $value }}" @selected($quote->status === $value)>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </dd>
                        <dt>Submitted</dt>
                        <dd>{{ $quote->created_at->format('d M, Y h:i A') }}</dd>
                    </dl>
                    <footer>
                        <a href="{{ route('quotes.show', $quote) }}">View</a>
                        <a href="{{ route('website.quote-generator.download', $quote->public_token) }}">PDF</a>
                    </footer>
                </article>
            @empty
                <p>No quote requests found yet.</p>
            @endforelse
        </div>

        @if($quotes->hasPages())
            <div class="admin-requests-pagination">{{ $quotes->links() }}</div>
        @endif
    </section>
@endsection
