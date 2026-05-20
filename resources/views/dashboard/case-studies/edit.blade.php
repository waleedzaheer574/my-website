@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Edit Case Study</h2>
@endsection

@section('content')
    <div class="card admin-u-024">
        <form action="{{ route('case-studies.update', $caseStudy) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('dashboard.case-studies._form', ['caseStudy' => $caseStudy])

            <div class="admin-u-025">
                <button type="submit" class="btn btn-primary">Update Case Study</button>
                <a href="{{ route('case-studies.index') }}" class="btn admin-u-005">Cancel</a>
            </div>
        </form>
    </div>
@endsection
