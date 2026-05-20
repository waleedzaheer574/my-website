@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Edit FAQ</h2>
@endsection

@section('content')
    <div class="card admin-u-039">
        <form action="{{ route('faqs.update', $faq) }}" method="POST">
            @csrf
            @method('PUT')

            @include('dashboard.faqs._form', ['faq' => $faq])

            <div class="admin-u-025">
                <button type="submit" class="btn btn-primary">Update FAQ</button>
                <a href="{{ route('faqs.index') }}" class="btn admin-u-005">Cancel</a>
            </div>
        </form>
    </div>
@endsection
