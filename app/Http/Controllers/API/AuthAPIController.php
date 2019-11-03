<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Auth;
use Validator;

class AuthAPIController extends Controller {

    public function login() {
        $output_array = array();
        $item_list = array();
        $item_array = array();
        $error_flag = 0;

        $email = empty(Input::get('email')) ? "" : Input::get('email');
        $password = empty(Input::get('password')) ? "" : Input::get('password');

        if ($email == "") {
            $error_flag = 1;
            $item_array['error_message'] = 'Email field is required.';
        } elseif ($password == "") {
            $error_flag = 1;
            $item_array['error_message'] = 'Password field is required.';
        }

        if ($error_flag != 1) {
            if (Auth::attempt(['email' => $email, 'password' => $password]) == "1") {

                $user = DB::table('users')
                        ->where('id', '=', Auth::id())
                        ->first();
                if ($user->status == "0" || $user->is_login == "1") {
                    $item_array['error_message'] = 'Invalid Credentials.';
                    $item_array['fetch_flag'] = "-1";
                }elseif ($user->type == "1" || $user->type == "2") {
	                $item_array['error_message'] = 'Invalid Credentials.';
	                $item_array['fetch_flag'] = "-1";
                } else {
                    DB::table('users')->where('id', '=', $user->id)->update(['is_login' => '1']);

                    $city = "";
	                $user_city = array();
                    if($user->city_id > 0 || $user->city_id != ""){
	                    $user_city = DB::table('cities')
	                                   ->where('id', '=', $user->city_id)
	                                   ->first();
	                    $city = $user_city->name;
                    }

                    $item_array = array();
                    $item_array['user_id'] = $user->id;
                    $item_array['user_type'] = $user->type;
                    $item_array['full_name'] = $user->name;
                    $item_array['user_name'] = $user->username;
                    $item_array['user_email'] = $user->email;
                    $item_array['city'] = strval($city);
                    $item_array['status'] = strval($user->status);
                    $item_array['is_login'] = strval($user->is_login);
                    $item_array['created_at'] = $user->created_at;
                    $item_array['fetch_flag'] = '1';
                }
            } else {
                $item_array['error_message'] = 'Invalid Credentials.';
                $item_array['fetch_flag'] = "-1";
            }
        } else {
            $item_array['fetch_flag'] = "-1";
        }
        array_push($item_list, $item_array);
        if($item_array['fetch_flag'] == "1"){
	        $output_array['login_details'] = $item_list;
        }else{
	        $output_array['login_error'] = $item_list;
        }

        echo json_encode($output_array);
    }

	public function logout() {
		$output_array = array();
		$item_list = array();
		$item_array = array();
		$error_flag = 0;

		$user_id = empty(Input::get('user_id')) ? "" : Input::get('user_id');

		if ($user_id == "") {
			$error_flag = 1;
			$item_array['error_message'] = 'User ID field is required.';
		}

		if ($error_flag != 1) {

			$res = DB::table('users')->where('id', '=', $user_id)->update(['is_login' => '0']);

			if ($res > 0) {

				$data                        = array();
				$data['oven_timer_1_5']      = '0';
				$data['oven_timer_6_10']     = '0';
				$data['oven_timer_10_20']    = '0';
				$data['oven_timer_20_30']    = '0';
				$data['oven_total_occupied'] = '0';
				$data['oven_empty_slots']    = '0';
				$data['gas_timer_1_5']       = '0';
				$data['gas_timer_6_10']      = '0';
				$data['gas_timer_10_20']     = '0';
				$data['gas_timer_20_30']     = '0';
				$data['gas_total_occupied']  = '0';
				$data['gas_empty_slots']     = '0';

				DB::table( 'timer_data' )->where( 'outlet_id', '=', $user_id )->update( $data );

			    $item_array['fetch_flag'] = '1';
			} else {
				$item_array['fetch_flag'] = "-1";
			}
		} else {
			$item_array['fetch_flag'] = "-1";
		}
		array_push($item_list, $item_array);
		if($item_array['fetch_flag'] == "1"){
			$output_array['logout_details'] = $item_list;
		}else{
			$output_array['logout_error'] = $item_list;
		}

		echo json_encode($output_array);
	}

    ############### Debug Controller ###############

    public function displayQuery($query_array) {
        foreach ($query_array as $query_item) {
            $query = $query_item['query'];
            $bindings = $query_item['bindings'];
            $search_array = array();
            $replace_array = array();
            foreach ($bindings as $item) {
                $search_array[] = "/\?/";
                $replace_array[] = "'" . $item . "'";
            }
            $main_query = preg_replace($search_array, $replace_array, $query, 1);
            echo $main_query . "<br>";
        }
    }

}

?>
