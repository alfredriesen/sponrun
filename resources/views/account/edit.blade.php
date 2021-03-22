@extends('layouts.app')
@section('title')
- Account bearbeiten
@endsection
@section('content')
<div class="row">
	<div class="col-md-6 offset-md-2">
		{{ Form::model($user, ['method' => 'PATCH', 'route' => 'account.update']) }}
		@include('auth.userForm', ['withEmail' => true])
		<div class="form-group">
			{{ Form::reset('Abbrechen', [ 'class' => "btn btn-secondary"]) }}
			{{ Form::submit('Speichern', [ 'class' => "btn btn-primary"]) }}
		</div>
	</div>
</div>
@endsection
