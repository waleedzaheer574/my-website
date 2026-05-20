@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Edit Why Nexa Item</h2>
@endsection

@section('content')
    <div class="card admin-u-039">
        <form action="{{ route('why-nexa.update', $whyNexa) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('dashboard.why-nexa._form', ['whyNexa' => $whyNexa])

            <div class="admin-u-025">
                <button type="submit" class="btn btn-primary">Update Item</button>
                <a href="{{ route('why-nexa.index') }}" class="btn admin-u-005">Cancel</a>
            </div>
        </form>
    </div>
@endsection
