@extends('layouts.app')
@section('title')
- Teilnahmen
@endsection
@section('content')
<div class="container">
    <div class="row">
		<div class="col-md-12">
			@include('layouts.messages')
            <div class="panel panel-default">
                <div class="panel-heading">Meine Teilnahmen</div>
                <div class="panel-body">
					<table class="table table-striped">
						<tr>
							<th>Datum</th>
							<th>Name</th>
							<th>Gelaufene Runden</th>
							<th>Sponsoren</th>
						</tr>
						@foreach ($runparts as $runpart)
						<tr>
							<td>{{ $runpart->sponsoredRun->begin->format('d.m.Y') }}</td>
							<td>{{ $runpart->sponsoredRun->name }}</td>
							<td>{{ $runpart->laps }}</td>
							<td><a class="btn btn-info"
								   href="{{route($root_route.'runpart.show', array_merge($root_route_params,[$runpart->id])) }}"
								   data-toggle="tooltip" title="Anzeigen">
									<span class="glyphicon glyphicon-list-alt"/></a>
								@if ( !$runpart->sponsoredRun->isElapsed() )
								<a class="btn btn-success"
								   href="{{route($root_route.'runpart.edit', array_merge($root_route_params,[$runpart->id])) }}"
								   data-toggle="tooltip" title="Bearbeiten">
									<span class="glyphicon glyphicon-pencil"/></a>
								@endif
						</tr>
						@endforeach
					</table>
					@if ( $runparts->isEmpty() )
					<p>Du hast noch keine Sponsorenläufe, an denen du teilnimmst.</p>
					@endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection