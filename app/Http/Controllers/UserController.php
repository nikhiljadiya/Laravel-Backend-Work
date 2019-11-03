<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Validator;

class UserController extends Controller {

	public function __construct() {
		$this->middleware( 'auth' );
	}

	public function index() {

		$users = DB::table( 'users' )->select( 'users.*', DB::raw( 'cities.name as city_name' ) )->leftJoin( 'cities', 'cities.id', '=', 'users.city_id' )->orderBy( 'users.id', 'desc' )->paginate( 10 );

		$cities = DB::table( 'cities' )->get();

		return view( 'users.index', compact( [ 'users', 'cities' ] ) );
	}

	public function search() {
		DB::enableQueryLog();

		$sort_field = empty( Input::get( 'sort_field' ) ) ? "" : Input::get( 'sort_field' );
		$sort_type  = empty( Input::get( 'sort_type' ) ) ? "" : Input::get( 'sort_type' );
		if ( $sort_field == '' && $sort_type == '' ) {
			$sort_field = 'users.id';
			$sort_type  = 'desc';
		}
		$search_param_array = Input::all();

		$type             = Input::get( 'type' );
		$type             = ( $type == "all" ) ? "" : strval( $type );
		$name             = empty( Input::get( 'name' ) ) ? "" : Input::get( 'name' );
		$city_id          = empty( Input::get( 'city_id' ) ) ? "" : Input::get( 'city_id' );
		$records_per_page = empty( Input::get( 'records_per_page' ) ) ? "10" : Input::get( 'records_per_page' );
		$users            = array();
		if ( $records_per_page == "all" ) {
			$users = DB::table( 'users' )->select( 'users.*', DB::raw( 'cities.name as city_name' ) )->leftJoin( 'cities', 'cities.id', '=', 'users.city_id' )->when( $type != "", function ( $users ) use ( $type ) {
					return $users->where( 'users.type', '=', '' . $type . '' );
				} )->when( $name, function ( $users ) use ( $name ) {
					return $users->where( 'users.name', 'LIKE', '%' . $name . '%' );
				} )->when( $city_id, function ( $users ) use ( $city_id ) {
					return $users->where( 'users.city_id', '=', $city_id );
				} )->orderBy( '' . $sort_field . '', '' . $sort_type . '' )->get();
		} else {
			$users = DB::table( 'users' )->select( 'users.*', DB::raw( 'cities.name as city_name' ) )->leftJoin( 'cities', 'cities.id', '=', 'users.city_id' )->when( $type != "", function ( $users ) use ( $type ) {
					return $users->where( 'users.type', '=', '' . $type . '' );
				} )->when( $name, function ( $users ) use ( $name ) {
					return $users->where( 'users.name', 'LIKE', '%' . $name . '%' );
				} )->when( $city_id, function ( $users ) use ( $city_id ) {
					return $users->where( 'users.city_id', '=', $city_id );
				} )->orderBy( '' . $sort_field . '', '' . $sort_type . '' )->paginate( $records_per_page )->setPath( '' );
			//dd(DB::getQueryLog());
			$pagination = $users->appends( $search_param_array );
		}

		$cities = DB::table( 'cities' )->get();

		return view( 'users.index', compact( [ 'users', 'cities' ] ) );
	}

	public function create() {
		$cities = DB::table( 'cities' )->get();

		$users = DB::table( 'users' )->select( 'id', 'name' )->where( 'type', '=', '0' )->orderBy( 'name' )->get();

		return view( 'users.create', compact( [ 'cities', 'users' ] ) );
	}

	public function store( Request $request ) {

		$type     = Input::get( 'type' );
		$user_ids     = empty( Input::get( 'user_ids' ) ) ? array() : Input::get( 'user_ids' );
		$name     = empty( Input::get( 'name' ) ) ? "" : Input::get( 'name' );
		$username = empty( Input::get( 'username' ) ) ? "" : Input::get( 'username' );
		$email    = empty( Input::get( 'email' ) ) ? "" : Input::get( 'email' );
		$password = empty( Input::get( 'password' ) ) ? "" : Input::get( 'password' );
		$city_id  = empty( Input::get( 'city_id' ) ) ? "" : Input::get( 'city_id' );
		$status   = Input::get( 'status' );

		$errors = array();
		if ( empty( $name ) ) {
			$errors[] = 'Name field is required.';
		}
		if ( empty( $username ) ) {
			$errors[] = 'Username field is required.';
		}
		if ( empty( $email ) ) {
			$errors[] = 'Email field is required.';
		}
		if ( empty( $password ) ) {
			$errors[] = 'Password field is required.';
		}
		if ( empty( $city_id ) ) {
			$errors[] = 'City field is required.';
		}

		$input['email'] = $email;
		$rules          = array( 'email' => 'unique:users,email' );
		$validator      = Validator::make( $input, $rules );

		if ( $validator->fails() ) {
			$errors[] = 'Email already exists.';
		}

		if ( count( $errors ) > 0 ) {
			return redirect()->back()->withErrors( $errors );
		} else {
			$data                   = array();
			$data['type']           = $type;
			$data['name']           = $name;
			$data['username']       = $username;
			$data['email']          = $email;
			$data['password']       = bcrypt( $password );
			$data['password_org']   = $password;
			$data['city_id']        = $city_id;
			$data['status']         = $status;
			$data['remember_token'] = str_random( 60 );
			$data['created_at']     = date( 'Y-m-d H:i:s' );
			$data['updated_at']     = date( 'Y-m-d H:i:s' );

			$user_id = DB::table( 'users' )->insertGetId( $data );
			if ( $user_id ) {

				foreach($user_ids as $item){
					$data = array();
					$data['manager_id'] = $user_id;
					$data['user_id'] = $item;
					DB::table( 'manager_users' )->insert( $data );
				}

				$this->addTimerData( $user_id );

				return redirect()->route( 'users.index' )->with( 'success', 'User has been created successfully.' );
			} else {
				return redirect()->back()->with( 'error', 'Sorry, User couldn\'t created.' );
			}
		}
	}

	public function show( $id ) {
		if ( empty( $id ) ) {
			return redirect()->back()->withErrors( [ 'Invalid User.' ] );
		}
		$user = DB::table( 'users' )->where( 'id', '=', $id )->first();
		if ( $user ) {
			$cities = DB::table( 'cities' )->get();

			return view( 'users.view', compact( [ 'user', 'cities' ] ) );
		} else {
			return redirect()->back()->withErrors( [ 'Invalid User.' ] );
		}
	}

	public function edit( $id ) {
		if ( empty( $id ) ) {
			return redirect()->back()->withErrors( [ 'Invalid User.' ] );
		}
		$user = DB::table( 'users' )->where( 'id', '=', $id )->first();
		if ( $user ) {
			$cities = DB::table( 'cities' )->get();

			$users = DB::table( 'users' )->select( 'id', 'name' )->where( 'type', '=', '0' )->orderBy( 'name' )->get();

			$manager_users = DB::table('manager_users')->where('manager_id', '=', $id)->get();
			$manager_users_array = array();
			foreach($manager_users as $item){
				$manager_users_array[] = $item->user_id;
			}

			return view( 'users.edit', compact( [ 'user', 'cities', 'users', 'manager_users_array' ] ) );
		} else {
			return redirect()->back()->withErrors( [ 'Invalid User.' ] );
		}
	}

	public function update( Request $request, $id ) {
		$type     = Input::get( 'type' );
		$user_ids     = empty( Input::get( 'user_ids' ) ) ? array() : Input::get( 'user_ids' );
		$name     = empty( Input::get( 'name' ) ) ? "" : Input::get( 'name' );
		$username = empty( Input::get( 'username' ) ) ? "" : Input::get( 'username' );
		$email    = empty( Input::get( 'email' ) ) ? "" : Input::get( 'email' );
		$password = empty( Input::get( 'password' ) ) ? "" : Input::get( 'password' );
		$city_id  = empty( Input::get( 'city_id' ) ) ? "" : Input::get( 'city_id' );
		$status   = Input::get( 'status' );

		$errors = array();
		if ( empty( $name ) ) {
			$errors[] = 'Name field is required.';
		}
		if ( empty( $username ) ) {
			$errors[] = 'Username field is required.';
		}
		if ( empty( $email ) ) {
			$errors[] = 'Email field is required.';
		}
		if ( empty( $city_id ) ) {
			$errors[] = 'City field is required.';
		}

		$user_count = DB::table( 'users' )->where( 'email', '=', $email )->where( 'id', '<>', $id )->count();

		if ( $user_count > 0 ) {
			$errors[] = 'Email already exists.';
		}

		if ( count( $errors ) > 0 ) {
			return redirect()->back()->withErrors( $errors );
		} else {
			$data             = array();
			$data['type']     = $type;
			$data['name']     = $name;
			$data['username'] = $username;
			$data['email']    = $email;
			if ( $password != "" ) {
				$data['password']     = bcrypt( $password );
				$data['password_org'] = $password;
			}
			$data['city_id']    = $city_id;
			$data['status']     = $status;
			$data['updated_at'] = date( 'Y-m-d H:i:s' );

			$result = DB::table( 'users' )->where( 'id', '=', $id )->update( $data );

			DB::table('manager_users')->where('manager_id', '=', $id)->delete();
			foreach($user_ids as $item){
				$data = array();
				$data['manager_id'] = $id;
				$data['user_id'] = $item;
				DB::table( 'manager_users' )->insert( $data );
			}

			$this->addTimerData( $id );

			return redirect()->route( 'users.index' )->with( 'success', 'User has been updated successfully.' );
		}
	}

	public function destroy( $id ) {
		if ( empty( $id ) ) {
			return redirect()->back()->withErrors( [ 'Invalid User.' ] );
		}

		$result = DB::table( 'users' )->where( 'id', '=', $id )->delete();

		DB::table( 'timer_data' )->where( 'outlet_id', '=', $id )->delete();
		DB::table( 'manager_users' )->where( 'manager_id', '=', $id )->delete();

		return redirect()->route( 'users.index' )->withSuccess( 'User has been deleted successfully.' );
	}

	public function multiDelete() {
		$item_ids       = empty( Input::get( 'item_ids' ) ) ? "" : trim( Input::get( 'item_ids' ), "," );
		$item_ids_array = explode( ",", $item_ids );
		if ( count( $item_ids_array ) > 0 && $item_ids_array[0] != "" ) {
			$result = DB::table( 'users' )->whereIn( 'id', $item_ids_array )->delete();
			DB::table( 'timer_data' )->whereIn( 'outlet_id', $item_ids_array )->delete();
			DB::table('manager_users')->whereIn('manager_id', $item_ids_array)->delete();
			return $result;
		} else {
			return '0';
		}
	}

	public function changeStatus() {
		$item_id = empty( Input::get( 'item_id' ) ) ? "" : Input::get( 'item_id' );
		$status  = empty( Input::get( 'status' ) ) ? "" : Input::get( 'status' );

		if ( $item_id != "" ) {
			$result = DB::table( 'users' )->where( 'id', $item_id )->update( [ 'status' => $status ] );

			return $result;
		} else {
			return '0';
		}
	}

	public function changeLoginStatus() {
		$item_id = empty( Input::get( 'item_id' ) ) ? "" : Input::get( 'item_id' );
		$status  = empty( Input::get( 'status' ) ) ? "" : Input::get( 'status' );

		if ( $item_id != "" ) {
			$result = DB::table( 'users' )->where( 'id', $item_id )->update( [ 'is_login' => $status ] );

			return $result;
		} else {
			return '0';
		}
	}

	public function addTimerData( $user_id ) {
		$count = DB::table( 'timer_data' )->where( 'outlet_id', '=', $user_id )->count();
		if ( $count < 1 ) {
			DB::table( 'timer_data' )->insert( [ 'outlet_id' => $user_id ] );
		}
	}

}
