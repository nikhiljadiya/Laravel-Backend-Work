<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class CityController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $cities = DB::table('cities')
                ->orderBy('id', 'desc')
                ->paginate(10);

        return view('cities.index', compact(['cities']));
    }

    public function search() {
        DB::enableQueryLog();

        $sort_field = empty(Input::get('sort_field')) ? "" : Input::get('sort_field');
        $sort_type = empty(Input::get('sort_type')) ? "" : Input::get('sort_type');
        if ($sort_field == '' && $sort_type == '') {
            $sort_field = 'id';
            $sort_type = 'desc';
        }
        $search_param_array = Input::all();

        $name = empty(Input::get('name')) ? "" : Input::get('name');
        $records_per_page = empty(Input::get('records_per_page')) ? "10" : Input::get('records_per_page');
        $cities = array();
        if ($records_per_page == "all") {
            $cities = DB::table('cities')
                    ->when($name, function($cities) use ($name) {
                        return $cities->where('name', 'LIKE', '%' . $name . '%');
                    })
                    ->orderBy('' . $sort_field . '', '' . $sort_type . '')
                    ->get();
        } else {
            $cities = DB::table('cities')
                    ->when($name, function($cities) use ($name) {
                        return $cities->where('name', 'LIKE', '%' . $name . '%');
                    })
                    ->orderBy('' . $sort_field . '', '' . $sort_type . '')
                    ->paginate($records_per_page)
                    ->setPath('');
            //dd(DB::getQueryLog());
            $pagination = $cities->appends($search_param_array);
        }

        return view('cities.index', compact(['cities']));
    }
    
    public function create() {
        return view('cities.create');
    }

    public function store(Request $request) {
        $name = empty(Input::get('name')) ? "" : Input::get('name');

        $errors = array();
        if (empty($name)) {
            $errors[] = 'Name field is required.';
        }

        $city_count = DB::table('cities')
                ->where('name', '=', $name)
                ->count();

        if ($city_count > 0) {
            $errors[] = 'City already exists.';
        }

        if (count($errors) > 0) {
            return redirect()->back()->withErrors($errors);
        } else {
            $data = array();
            $data['name'] = $name;

            $city_id = DB::table('cities')->insertGetId($data);
            if ($city_id) {
                return redirect()->route('cities.index')->with('success', 'City has been created successfully.');
            }
        }
    }

    public function show($id) {
        
    }

    public function edit($id) {
        if (empty($id)) {
            return redirect()->back()->withErrors(['Invalid City.']);
        }
        $city = DB::table('cities')->where('id', '=', $id)->first();
        if ($city) {
            return view('cities.edit', compact(['city']));
        } else {
            return redirect()->back()->withErrors(['Invalid City.']);
        }
    }

    public function update(Request $request, $id) {
        $name = empty(Input::get('name')) ? "" : Input::get('name');

        $errors = array();
        if (empty($name)) {
            $errors[] = 'Name field is required.';
        }

        $city_count = DB::table('cities')
                ->where('name', '=', $name)
                ->where('id', '<>', $id)
                ->count();

        if ($city_count > 0) {
            $errors[] = 'City already exists.';
        }

        if (count($errors) > 0) {
            return redirect()->back()->withErrors($errors);
        } else {
            $data = array();
            $data['name'] = $name;
            $result = DB::table('cities')
                    ->where('id', '=', $id)
                    ->update($data);
            return redirect()->route('cities.index')->with('success', 'City has been updated successfully.');
        }
    }

    public function destroy($id) {
        if (empty($id)) {
            return redirect()->back()->withErrors(['Invalid City.']);
        }
        DB::table('cities')
                ->where('id', '=', $id)
                ->delete();

        return redirect()->route('cities.index')->withSuccess('City has been deleted successfully.');
    }

    public function multiDelete() {
        $item_ids = empty(Input::get('item_ids')) ? "" : trim(Input::get('item_ids'), ",");
        $item_ids_array = explode(",", $item_ids);
        if (count($item_ids_array) > 0 && $item_ids_array[0] != "") {
            $result = DB::table('cities')
                    ->whereIn('id', $item_ids_array)
                    ->delete();
            return $result;
        } else {
            return '0';
        }
    }

}
