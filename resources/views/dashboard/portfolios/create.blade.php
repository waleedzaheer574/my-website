@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Add New Portfolio</h2>
@endsection

@section('content')
    <div class="card admin-u-024">
        <form action="{{ route('portfolios.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('dashboard.portfolios._form', ['portfolio' => null])

            <div class="admin-u-025">
                <button type="submit" class="btn btn-primary">Save Portfolio</button>
                <a href="{{ route('portfolios.index') }}" class="btn admin-u-005">Cancel</a>
            </div>
        </form>
    </div>
@endsection
