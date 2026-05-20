@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Edit Client Review</h2>
@endsection

@section('content')
    <div class="card admin-u-039">
        <form action="{{ route('reviews.update', $review) }}" method="POST">
            @csrf
            @method('PUT')

            @include('dashboard.reviews._form', ['review' => $review])

            <div class="admin-u-025">
                <button type="submit" class="btn btn-primary">Update Review</button>
                <a href="{{ route('reviews.index') }}" class="btn admin-u-005">Cancel</a>
            </div>
        </form>
    </div>
@endsection
