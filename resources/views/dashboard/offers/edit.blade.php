@extends('layouts.admin')

@section('header')
  <h2 class="admin-u-001">Edit Offer</h2>
@endsection

@section('content')
<div class="card">
  <form action="{{ route('offers.admin.update', $offer) }}" method="POST">
    @csrf
    @method('PUT')
    @include('dashboard.offers._form')
  </form>
</div>
@endsection
