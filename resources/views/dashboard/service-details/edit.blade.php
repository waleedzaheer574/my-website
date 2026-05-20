@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Edit Service Detail</h2>
@endsection

@section('content')
    <div class="card admin-u-067">
        <form action="{{ route('service-details.update', $serviceDetail->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('dashboard.service-details._form')
            <div class="admin-u-044">
                <button type="submit" class="btn btn-primary">Update Service Detail</button>
                <a href="{{ route('service-details.index') }}" class="btn admin-u-005">Cancel</a>
            </div>
        </form>
    </div>
@endsection
