@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Add Why Nexa Item</h2>
@endsection

@section('content')
    <div class="card admin-u-039">
        <form action="{{ route('why-nexa.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('dashboard.why-nexa._form', ['whyNexa' => null])

            <div class="admin-u-025">
                <button type="submit" class="btn btn-primary">Save Item</button>
                <a href="{{ route('why-nexa.index') }}" class="btn admin-u-005">Cancel</a>
            </div>
        </form>
    </div>
@endsection
