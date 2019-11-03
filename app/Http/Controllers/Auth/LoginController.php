<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller {
	/*
	|--------------------------------------------------------------------------
	| Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles authenticating users for the application and
	| redirecting them to your home screen. The controller uses a trait
	| to conveniently provide its functionality to your applications.
	|
	*/

	use AuthenticatesUsers;

	/**
	 * Where to redirect users after login.
	 *
	 * @var string
	 */
	protected $redirectTo = '/';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware( 'guest' )->except( 'logout' );
	}

	public function login() {
		$email    = Input::get( 'email' );
		$password = Input::get( 'password' );
		$flag = false;
		if ( Auth::attempt( [ 'email' => $email, 'password' => $password ] ) == "1" ) {
			$user_id = Auth::id();
			if ( isset( $user_id ) ) {
				$user = DB::table( 'users' )->where( 'id', '=', $user_id )->first();
				if($user->type == "1" || $user->type == "2"){
					$flag = true;
				}
			}
		}

		if($flag){
			return redirect('/');
		}else{
			Auth::logout();
			return redirect()->back()->withErrors( [ 'email' => 'These credentials do not match our records.' ] );
		}
	}
}
