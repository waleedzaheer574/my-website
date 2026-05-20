@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Edit Industry</h2>
@endsection

@section('content')
    <div class="card admin-u-039">
        <form action="{{ route('industries.update', $industry) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('dashboard.industries._form', ['industry' => $industry])

            <div class="admin-u-025">
                <button type="submit" class="btn btn-primary">Update Industry</button>
                <a href="{{ route('industries.index') }}" class="btn admin-u-005">Cancel</a>
            </div>
        </form>
    </div>
@endsection
