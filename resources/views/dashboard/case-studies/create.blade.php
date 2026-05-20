@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Add New Case Study</h2>
@endsection

@section('content')
    <div class="card admin-u-024">
        <form action="{{ route('case-studies.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            @include('dashboard.case-studies._form', ['caseStudy' => null])

            <div class="admin-u-025">
                <button type="submit" class="btn btn-primary">Save Case Study</button>
                <a href="{{ route('case-studies.index') }}" class="btn admin-u-005">Cancel</a>
            </div>
        </form>
    </div>
@endsection
