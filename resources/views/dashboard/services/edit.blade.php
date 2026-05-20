@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Edit Service</h2>
@endsection

@section('content')
    <div class="card admin-u-067">
        <form action="{{ route('services.update', $service->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('dashboard.services._form')
        </form>
    </div>
@endsection
