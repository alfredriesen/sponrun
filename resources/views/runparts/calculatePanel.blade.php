<div class="col-md-4">
	<div class="card card-default">
		<div class="card-header">Wie viel würde ich sammeln, wenn...</div>
		<div class="card-body">
			{{ Form::open([
				'method' => 'GET',
				'url' => route($root_route.'runpart.calculate', array_merge($root_route_params, [$runpart->id])),
				'class' => 'form-inline '.($errors->has('laps') ? ' has-error' : '')]) }}
			<p>ich 
				{{ Form::number('laps', $laps, [ 'class' => "form-control", 'min' => "0", 'step' => "1", 'style' => "width: 60px"]) }}
				Runden laufen würde?
				<span role="button" class="glyphicon glyphicon-info-sign" data-toggle="modal" data-target="#calculation_dlg"></span>
			</p>
			<p>
				{{ Form::submit('Ausrechnen', [ 'class' => "btn btn-primary"]) }}
			</p>
			@if ($errors->has('laps'))
			<span class="help-block">
				<strong>{{ $errors->first('laps') }}</strong>
			</span>
			@endif
			{{ Form::close() }}
			@if(isset($sum))
			<hr>
			Du würdest <b>{{ number_format($sum,2) }} €</b> sammeln.
			@endif
		</div>
	</div>
</div>