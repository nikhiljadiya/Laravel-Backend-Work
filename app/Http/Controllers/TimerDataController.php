<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class TimerDataController extends Controller {

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct() {
		$this->middleware( 'auth' );
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {

		$timer_data = DB::table( 'timer_data' )->select( 'timer_data.*', DB::raw( 'users.name as outlet_name' ), DB::raw( 'cities.name as city' ) )->leftJoin( 'users', 'users.id', '=', 'timer_data.outlet_id' )->leftJoin( 'cities', 'cities.id', '=', 'users.city_id' )->get();

		return view( 'home', compact( [ 'timer_data' ] ) );
	}

}
