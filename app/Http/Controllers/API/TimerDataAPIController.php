<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class TimerDataAPIController extends Controller {

	public function getTimerData() {

		$output_array = array();
		$item_list    = array();
		$item_array   = array();
		$error_flag   = 0;

		$timer_data = DB::table( 'timer_data' )->select( 'timer_data.*', DB::raw( 'users.name as outlet_name' ), DB::raw( 'cities.name as city' ) )->leftJoin( 'users', 'users.id', '=', 'timer_data.outlet_id' )->leftJoin( 'cities', 'cities.id', '=', 'users.city_id' )->get();

		foreach ( $timer_data as $item ) {
			$item_array                        = array();
			$item_array['outlet_id']           = $item->outlet_id;
			$item_array['outlet_name']         = $item->outlet_name;
			$item_array['city']                = $item->city;
			$item_array['oven_timer_1_5']      = $item->oven_timer_1_5;
			$item_array['oven_timer_6_10']     = $item->oven_timer_6_10;
			$item_array['oven_timer_10_20']    = $item->oven_timer_10_20;
			$item_array['oven_timer_20_30']    = $item->oven_timer_20_30;
			$item_array['oven_total_occupied'] = $item->oven_total_occupied;
			$item_array['oven_empty_slots']    = $item->oven_empty_slots;
			$item_array['gas_timer_1_5']       = $item->gas_timer_1_5;
			$item_array['gas_timer_6_10']      = $item->gas_timer_6_10;
			$item_array['gas_timer_10_20']     = $item->gas_timer_10_20;
			$item_array['gas_timer_20_30']     = $item->gas_timer_20_30;
			$item_array['gas_total_occupied']  = $item->gas_total_occupied;
			$item_array['gas_empty_slots']     = $item->gas_empty_slots;
			array_push( $item_list, $item_array );
		}

		$output_array['timer_data'] = $item_list;
		echo json_encode( $output_array );
	}

	public function saveTimerData() {

		$output_array = array();
		$item_list    = array();
		$item_array   = array();
		$error_flag   = 0;

		$outlet_id           = empty( Input::get( 'outlet_id' ) ) ? "" : Input::get( 'outlet_id' );
		$oven_timer_1_5      = empty( Input::get( 'oven_timer_1_5' ) ) ? "0" : Input::get( 'oven_timer_1_5' );
		$oven_timer_6_10     = empty( Input::get( 'oven_timer_6_10' ) ) ? "0" : Input::get( 'oven_timer_6_10' );
		$oven_timer_10_20    = empty( Input::get( 'oven_timer_10_20' ) ) ? "0" : Input::get( 'oven_timer_10_20' );
		$oven_timer_20_30    = empty( Input::get( 'oven_timer_20_30' ) ) ? "0" : Input::get( 'oven_timer_20_30' );
		$oven_total_occupied = empty( Input::get( 'oven_total_occupied' ) ) ? "0" : Input::get( 'oven_total_occupied' );
		$oven_empty_slots    = empty( Input::get( 'oven_empty_slots' ) ) ? "0" : Input::get( 'oven_empty_slots' );
		$gas_timer_1_5       = empty( Input::get( 'gas_timer_1_5' ) ) ? "0" : Input::get( 'gas_timer_1_5' );
		$gas_timer_6_10      = empty( Input::get( 'gas_timer_6_10' ) ) ? "0" : Input::get( 'gas_timer_6_10' );
		$gas_timer_10_20     = empty( Input::get( 'gas_timer_10_20' ) ) ? "0" : Input::get( 'gas_timer_10_20' );
		$gas_timer_20_30     = empty( Input::get( 'gas_timer_20_30' ) ) ? "0" : Input::get( 'gas_timer_20_30' );
		$gas_total_occupied  = empty( Input::get( 'gas_total_occupied' ) ) ? "0" : Input::get( 'gas_total_occupied' );
		$gas_empty_slots     = empty( Input::get( 'gas_empty_slots' ) ) ? "0" : Input::get( 'gas_empty_slots' );


		if ( $outlet_id == "" ) {
			$error_flag                  = 1;
			$item_array['error_message'] = 'Outlet ID field is required.';
		}

		if ( $error_flag != 1 ) {
			$data                        = array();
			$data['oven_timer_1_5']      = $oven_timer_1_5;
			$data['oven_timer_6_10']     = $oven_timer_6_10;
			$data['oven_timer_10_20']    = $oven_timer_10_20;
			$data['oven_timer_20_30']    = $oven_timer_20_30;
			$data['oven_total_occupied'] = $oven_total_occupied;
			$data['oven_empty_slots']    = $oven_empty_slots;
			$data['gas_timer_1_5']       = $gas_timer_1_5;
			$data['gas_timer_6_10']      = $gas_timer_6_10;
			$data['gas_timer_10_20']     = $gas_timer_10_20;
			$data['gas_timer_20_30']     = $gas_timer_20_30;
			$data['gas_total_occupied']  = $gas_total_occupied;
			$data['gas_empty_slots']     = $gas_empty_slots;

			$result = DB::table( 'timer_data' )->where( 'outlet_id', '=', $outlet_id )->update( $data );
			if ( $result ) {
				$item_array['fetch_flag'] = "1";
			} else {
				$item_array['fetch_flag'] = "-1";
			}
		} else {

		}

		array_push( $item_list, $item_array );
		$output_array['save_timer_data'] = $item_list;
		echo json_encode( $output_array );
	}

}
