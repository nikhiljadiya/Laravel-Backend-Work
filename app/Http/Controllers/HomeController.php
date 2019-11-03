<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

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
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $current_user = Auth::user();

        $timer_data = DB::table('timer_data')->select('timer_data.*', DB::raw('users.name as outlet_name'), DB::raw('cities.name as city'))->leftJoin('users', 'users.id', '=', 'timer_data.outlet_id')->leftJoin('cities', 'cities.id', '=', 'users.city_id')->when(
            $current_user['type'] == "2", function ( $timer_data ) {
                return $timer_data->whereIn(
                    'users.id', function ( $query ) {
                        $query->select('user_id')->from('manager_users')->where('manager_id', '=', Auth::id());
                    } 
                );
            } 
        )->where('users.type', '=', '0')->get();

        return view('home', compact([ 'timer_data' ]));
    }

    public function refreshTimerData()
    {
        $current_user = Auth::user();
        $timer_data   = DB::table('timer_data')->select('timer_data.*', DB::raw('users.name as outlet_name'), DB::raw('cities.name as city'))->leftJoin('users', 'users.id', '=', 'timer_data.outlet_id')->leftJoin('cities', 'cities.id', '=', 'users.city_id')->when(
            $current_user['type'] == "2", function ( $timer_data ) {
                return $timer_data->whereIn(
                    'users.id', function ( $query ) {
                        $query->select('user_id')->from('manager_users')->where('manager_id', '=', Auth::id());
                    } 
                );
            } 
        )->where('users.type', '=', '0')->get();

        $html = '';
        foreach ( $timer_data as $item ) {
            $html .= '<tr id="outlet_' . $item->outlet_id . '">';
            $html .= '<td class="text-center">' . $item->city . '</td>';
            $html .= '<td class="text-center">' . $item->outlet_name . '</td>';
            $html .= '<td class="tbl-divider-bg">&nbsp;</td>';
            $html .= '<td class="text-center">' . $item->oven_timer_1_5 . '</td>';
            $html .= '<td class="text-center">' . $item->oven_timer_6_10 . '</td>';
            $html .= '<td class="text-center">' . $item->oven_timer_10_20 . '</td>';
            $html .= '<td class="text-center">' . $item->oven_timer_20_30 . '</td>';
            $html .= '<td class="text-center">' . $item->oven_total_occupied . '</td>';
            $html .= '<td class="text-center">' . $item->oven_empty_slots . '</td>';
            $html .= '<td class="tbl-divider-bg">&nbsp;</tdclass>';
            $html .= '<td class="text-center">' . $item->gas_timer_1_5 . '</td>';
            $html .= '<td class="text-center">' . $item->gas_timer_6_10 . '</td>';
            $html .= '<td class="text-center">' . $item->gas_total_occupied . '</td>';
            $html .= '<td class="text-center">' . $item->gas_empty_slots . '</td>';
            $html .= '</tr>';
        }
        echo $html;
    }

}
