@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">View Service Detail</h2>
@endsection

@section('content')
    <div class="card">
        <h3>{{ trim(($serviceDetail->title_prefix ?? '') . ' ' . ($serviceDetail->title_highlight ?? '')) }}</h3>
        <p>{{ $serviceDetail->description }}</p>
        <p><strong>Slug:</strong> {{ $serviceDetail->slug }}</p>
        <p><strong>Service:</strong> {{ $serviceDetail->service?->service_title ?? 'Not linked' }}</p>
        <div class="admin-u-044">
            <a href="{{ route('service-details.edit', $serviceDetail->id) }}" class="btn btn-primary">Edit</a>
            <a href="{{ route('service-details.index') }}" class="btn admin-u-005">Back</a>
        </div>
    </div>
@endsection
