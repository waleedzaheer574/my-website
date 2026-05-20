@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Add Client Review</h2>
@endsection

@section('content')
    <div class="card admin-u-039">
        <form action="{{ route('reviews.store') }}" method="POST">
            @csrf

            @include('dashboard.reviews._form', ['review' => null])

            <div class="admin-u-025">
                <button type="submit" class="btn btn-primary">Save Review</button>
                <a href="{{ route('reviews.index') }}" class="btn admin-u-005">Cancel</a>
            </div>
        </form>
    </div>
@endsection
