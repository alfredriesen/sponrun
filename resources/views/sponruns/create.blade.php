@extends('layouts.app')
@section('title')
- Sponsorenlauf anlegen
@endsection
@section('content')
<div class="row">
	<div class="col-md-6 offset-md-2">
		{{ Form::open([
		'url' => route($root_route.'sponrun.store', $root_route_params)]) }}
		@include('sponruns.sponrunForm')
		{{ Form::close() }}
	</div>
</div>
@endsection