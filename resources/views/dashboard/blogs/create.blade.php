@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Create Blog</h2>
@endsection

@section('content')
    <div class="card">
        <form action="{{ route('blogs.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('dashboard.blogs._form')

            <div class="admin-u-009">
                <a href="{{ route('blogs.index') }}" class="btn admin-u-005">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Blog</button>
            </div>
        </form>
    </div>
@endsection
