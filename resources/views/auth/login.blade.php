@extends('layouts.app')
@section('title')
- Login
@endsection
@section('content')
<div class="row">            
	<div class="col-md-4">
		<img class="img-responsive" alt="To All Nations" src="{{ url('/images/logo.jpg') }}">
	</div>
	<div class="col-md-6 col-md-offset-1">
		@include('auth.loginPanel')
	</div>
</div>
@endsection
