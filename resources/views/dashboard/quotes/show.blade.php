@extends('layouts.admin')

@section('title', $quote->reference)
@section('header')
    <h2 class="admin-u-001">{{ $quote->reference }}</h2>
@endsection

@section('content')
    <div class="card">
        <div class="admin-u-026">
            <div>
                <h3 class="admin-u-049">Quote Details</h3>
                <p class="admin-u-028">{{ $quote->service_title }} estimate for {{ $quote->client_name }}.</p>
            </div>
            <a class="btn btn-primary" href="{{ route('website.quote-generator.download', $quote->public_token) }}">Download PDF</a>
        </div>

        <div class="admin-quote-grid">
            <div class="admin-quote-card"><span>Estimate</span><strong>{{ $quote->estimate_label }}</strong></div>
            <div class="admin-quote-card"><span>Budget</span><strong>{{ $quote->budget_label }}</strong></div>
            <div class="admin-quote-card"><span>Timeline</span><strong>{{ $quote->timeline_label }}</strong></div>
            <div class="admin-quote-card">
                <span>Status</span>
                <form action="{{ route('quotes.status.update', $quote) }}" method="POST" class="admin-status-form admin-status-form-card">
                    @csrf
                    @method('PATCH')
                    <select name="status" onchange="this.form.submit()">
                        @foreach($statuses as $value => $label)
                            <option value="{{ $value }}" @selected($quote->status === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>

        <div class="admin-quote-section">
            <h3>Client</h3>
            <p><strong>{{ $quote->client_name }}</strong>{{ $quote->company_name ? ' · '.$quote->company_name : '' }}</p>
            <p><a class="admin-u-084" href="mailto:{{ $quote->client_email }}">{{ $quote->client_email }}</a>{{ $quote->client_phone ? ' · '.$quote->client_phone : '' }}</p>
        </div>

        <div class="admin-quote-section">
            <h3>Requirements</h3>
            <p>{{ $quote->requirements }}</p>
        </div>

        <div class="admin-quote-section">
            <h3>Deliverables</h3>
            <ul>
                @foreach($quote->deliverables ?? [] as $deliverable)
                    <li>{{ $deliverable }}</li>
                @endforeach
            </ul>
        </div>

        <div class="admin-quote-section">
            <h3>Assumptions</h3>
            <ul>
                @foreach($quote->assumptions ?? [] as $assumption)
                    <li>{{ $assumption }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
