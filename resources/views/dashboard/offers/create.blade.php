@extends('layouts.admin')

@section('header')
  <h2 class="admin-u-001">Create Offer</h2>
@endsection

@section('content')
<div class="card">
  <form action="{{ route('offers.admin.store') }}" method="POST">
    @csrf
    @include('dashboard.offers._form')
  </form>
</div>
@endsection
