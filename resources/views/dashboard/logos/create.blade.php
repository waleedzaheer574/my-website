@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Add New Logo</h2>
@endsection

@section('content')
    <div class="card admin-u-043">
        <form action="{{ route('logos.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label for="logo">Logo</label>
                <input type="file" name="logo" id="logo" class="form-control" accept="image/*" required>
                @error('logo') <small class="admin-u-021">{{ $message }}</small> @enderror
            </div>

            <div class="admin-u-044">
                <button type="submit" class="btn btn-primary">Save Logo</button>
                <a href="{{ route('logos.index') }}" class="btn admin-u-005">Cancel</a>
            </div>
        </form>
    </div>
@endsection
