@include('formfields.firstname', ['required' => true])
@include('formfields.lastname', ['required' => true])
@if (isset($withEmail) && $withEmail)
	@include('formfields.email', ['required' => true])
@endif
@include('formfields.street_housenumber', ['required' => true])
@include('formfields.postcode_city', ['required' => true])
@include('formfields.birthday', ['required' => true])
@include('formfields.gender', ['required' => true])
@include('formfields.phone')
@if (config('app.newsletter_optional'))
	@include('formfields.wants_newsletter')
@endif
