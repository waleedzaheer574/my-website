@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Add New Industry</h2>
@endsection

@section('content')
    <div class="card admin-u-039">
        <form action="{{ route('industries.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('dashboard.industries._form', ['industry' => null])

            <div class="admin-u-025">
                <button type="submit" class="btn btn-primary">Save Industry</button>
                <a href="{{ route('industries.index') }}" class="btn admin-u-005">Cancel</a>
            </div>
        </form>
    </div>
@endsection
