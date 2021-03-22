<?php

namespace App\Http\Controllers;

use App\Notifications\VerifyEmail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AccoController extends Controller
{

	private $validation = [
		'firstname' => 'string|max:255',
		'lastname' => 'string|max:255',
		'email' => 'email|max:255|unique:users',
		'street' => 'string|max:255',
		'housenumber' => 'string|max:31',
		'postcode' => 'numeric|between:0,99999',
		'city' => 'string|max:255',
		'birthday' => 'date',
		'gender' => 'in:m,f',
		'phone' => 'nullable|phone:AUTO,DE',
		'wants_newsletter' => 'boolean',
	];

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show()
	{
		return redirect()->route('user.edit');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @return Response
	 */
	public function edit()
	{
		$user = Auth::user();
		return view('account.edit')->with('user', $user);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function update(Request $request)
	{
		$user = Auth::user();

		// Ignore unique condition when email does not change
		$this->validation['email'] = [
			'email',
			'max:255',
        	Rule::unique('users')->ignore($user->id)
		];

		$request->validate($this->validation);
		if (isset($request->birthday)) {
			$request->birthday = strtotime($request->birthday);
		}

		$requestFields = $request->all();
		$oldEmail = $user->email;
		$isEmailUpdate = $requestFields['email'] !== $oldEmail;

		if($isEmailUpdate) {
			$user->email = $requestFields['email'];
			$user->notify(new VerifyEmail(str_random(30), true, $oldEmail));
			$user->email = $oldEmail;
			$requestFields['confirmation_code'] = $requestFields['email'];
			unset($requestFields['email']);
		}

		$user->update($requestFields);

		if ($request->wantsJson()) {
			return response()->json($user);
		}
		$messages = ["Erfolgreich gespeichert"];

		if ($isEmailUpdate) {
			$messages[] = "Dir wurde eine Email zugesenden. Bitte bestätige deine neue Email-Adresse.";
		}
		Session::flash('messages-success', new MessageBag($messages));
		return redirect()->route('account.edit');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy()
	{
		//
	}

}
