@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Add New Service</h2>
@endsection

@section('content')
    <div class="card admin-u-067">
        <form action="{{ route('services.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('dashboard.services._form', ['service' => null])
        </form>
    </div>
@endsection
