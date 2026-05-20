@extends('layouts.admin')

@section('header')
    <h2 class="admin-u-001">Edit Logo</h2>
@endsection

@section('content')
    <div class="card admin-u-043">
        <form action="{{ route('logos.update', $logo->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="logo">Logo</label>
                @if($logo->logo)
                    <div class="admin-u-045">
                        <img class="admin-u-080" src="{{ asset('storage/' . $logo->logo) }}" alt="Current Logo">
                    </div>
                @endif
                <input type="file" name="logo" id="logo" class="form-control" accept="image/*">
                <small class="admin-u-046">Leave blank if you do not want to change the current logo.</small>
                @error('logo') <small class="admin-u-021">{{ $message }}</small> @enderror
            </div>

            <div class="admin-u-044">
                <button type="submit" class="btn btn-primary">Update Logo</button>
                <a href="{{ route('logos.index') }}" class="btn admin-u-005">Cancel</a>
            </div>
        </form>
    </div>
@endsection
