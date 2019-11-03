@extends('layouts.master')@section('title', 'Admin | Cities')
@section('content')

	<?php

	use Illuminate\Support\Facades\Input;
	?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage Cities </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Cities</li>
        </ol>
    </section>
    <!-- Content Header (Page header) -->

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                            <i class="fa fa-align-justify"></i><span class="break"></span> Manage Cities </h3>

                        <div class="pull-right box-tools">
                            <a class="btn btn-primary btn-sm" href="{{ route('cities.create') }}" data-toggle="tooltip" title="Add New" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                            <a class="btn btn-danger btn-sm" href="javascript:void(0);" data-toggle="tooltip" title="Remove" data-original-title="Remove" onclick="multiDelete();"><i class="fa fa-trash-o"></i></a>
                        </div>
                    </div>

                    <div class="box-body">

                        <!-- Success Message Start -->
                    @include('alerts.success')
                    <!-- Success Message End -->

                        <form action="{{ route('cities.search') }}" method="post">
                            {{ csrf_field() }}
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="status">Status</label>
                                        <select name="status" id="status" class="form-control select2" style="width: 100%;">
                                            <option value="all" {{ (Input::get('status') == 'all' || Input::get('status') == null) ? 'selected="selected"' : '' }}>All</option>
                                            <option value="1" {{ (Input::get('status') == '1') ? 'selected="selected"' : '' }}>Active</option>
                                            <option value="0" {{ (Input::get('status') == '0') ? 'selected="selected"' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Name">Name</label>
                                        <input type="text" id="name" name="name" value="{{ Input::get('name') }}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Records Per Page">Records Per Page</label>
                                        <select name="records_per_page" id="records_per_page" class="form-control select2" style="width: 100%;">
                                            <option value="all" {{ (Input::get('records_per_page') == 'all') ? 'selected="selected"' : '' }}>All</option>
                                            <option value="10" {{ (Input::get('records_per_page') == '10' || Input::get('records_per_page') == null) ? 'selected="selected"' : '' }}>10</option>
                                            <option value="20" {{ (Input::get('records_per_page') == '20') ? 'selected="selected"' : '' }}>20</option>
                                            <option value="30" {{ (Input::get('records_per_page') == '30') ? 'selected="selected"' : '' }}>30</option>
                                            <option value="50" {{ (Input::get('records_per_page') == '50') ? 'selected="selected"' : '' }}>50</option>
                                            <option value="100" {{ (Input::get('records_per_page') == '100') ? 'selected="selected"' : '' }}>100</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="">&nbsp;</label><br>
                                        <button class="btn btn-primary btn-flat" name="btn_search" id="btn_search" value="search">Search</button>
                                    </div>
                                </div>

                            </div>
                        </form>

						<?php
						$arrow = 'fa fa-unsorted';
						$arrow_up = 'fa fa-sort-asc';
						$arrow_down = 'fa fa-sort-desc';

						$id_arrow = $arrow;
						$name_arrow = $arrow;

						$sort_arrow = $arrow;
						$sort_type = "asc";
						if ( Input::get( 'sort_type' ) == '' || Input::get( 'sort_type' ) == 'desc' ) {
							$sort_type  = "asc";
							$sort_arrow = $arrow_down;
						} else if ( Input::get( 'sort_type' ) == 'asc' ) {
							$sort_type  = "desc";
							$sort_arrow = $arrow_up;
						}

						$query_string = http_build_query( Request::except( [ 'sort_field', 'sort_type' ] ) );
						$sort_url_str = route( 'cities.search' ) . '?' . $query_string;

						$id_type = "asc";
						if ( Input::get( 'sort_field' ) == "id" ) {
							$id_type  = $sort_type;
							$id_arrow = $sort_arrow;
						}
						$id_sort_url = url( $sort_url_str . '&sort_field=id&sort_type=' . $id_type );

						$name_type = "asc";
						if ( Input::get( 'sort_field' ) == "name" ) {
							$name_type  = $sort_type;
							$name_arrow = $sort_arrow;
						}
						$name_sort_url = url( $sort_url_str . '&sort_field=name&sort_type=' . $name_type );

						?>

                        @if(Input::get('records_per_page') != "all")
                            <div class="pull-right">
                                <p>Showing {{ $cities->firstItem() }} to {{ $cities->lastItem() }} of {{ $cities->total() }} entries</p>
                            </div>
                        @endif

                        <div class="table-responsive clearfix">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th class="chk-list-width text-center" style="width: 10%">
                                        <input type="checkbox" id="chk_list_all" name="chk_list_all"/>
                                    </th>
                                    <th class="text-center" style="width: 10%">
                                        <a href="{{ $id_sort_url }}">ID&nbsp;<i class="{{ $id_arrow }}"></i></a></th>
                                    <th class="">
                                        <a href="{{ $name_sort_url }}">Name&nbsp;<i class="{{ $name_arrow }}"></i></a>
                                    </th>
                                    <th class="text-center"><a href="javascript:void(0);">Action</a></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($cities as $city)
                                    <tr>
                                        <td class="text-center">
                                            <input type="checkbox" id="chk_list_id_{{ $city->id }}" name="chk_list[]" value="{{ $city->id }}"/>
                                        </td>
                                        <td class="text-center">{{ $city->id }}</td>
                                        <td>{{ $city->name }}</td>
                                        <td class="text-center">
                                            <a class="btn btn-primary btn-sm" href="{{ route('cities.edit', [$city->id]) }}" data-toggle="tooltip" title="Edit" data-original-title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <form action="{{ route('cities.destroy', [$city->id]) }}" method="POST" style="display: inline;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Remove City" data-original-title="Remove City">
                                                    <i class="fa fa-trash-o"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">No Cities Found.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="box-footer clearfix">
                        @if(Input::get('records_per_page') != "all")
                            <div class="pull-right">
                                {!! $cities->links() !!}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </section>
    <!-- Main content -->
@endsection

@section('custom-scripts')
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery(".icheckbox_square-blue > #chk_list_all").on('ifChanged', function (e) {
                var checkboxes = document.getElementsByName('chk_list[]');
                var checkValue = jQuery(this).iCheck('update')[0].checked;
                if (checkValue) {
                    for (var i = 0; i < checkboxes.length; i++) {
                        if (checkboxes[i].type == 'checkbox') {
                            checkboxes[i].checked = true;
                            checkboxes[i].parentNode.classList.add("checked");
                            checkboxes[i].setAttribute("checked", "checked");
                        }
                    }
                } else {
                    for (var i = 0; i < checkboxes.length; i++) {
                        if (checkboxes[i].type == 'checkbox') {
                            checkboxes[i].checked = false;
                            checkboxes[i].parentNode.classList.remove("checked");
                            checkboxes[i].removeAttribute("checked");
                        }
                    }
                }
            });
        });

        function multiDelete() {

            checkboxes = document.getElementsByName('chk_list[]');
            var item_ids = "";
            for (var i in checkboxes) {
                if (checkboxes[i].id !== undefined) {
                    if (checkboxes[i].checked) {
                        item_ids += checkboxes[i].value + ",";
                    }
                }
            }
            item_ids = item_ids.replace(/,\s*$/, "");
            if (item_ids === "") {
                alert("Please select at least one record from list.");
                return false;
            } else {
                var r = confirm("Are you sure to delete?");
                if (r == true) {
                } else {
                    return false;
                }
                $.ajax({
                    type: "GET",
                    url: '<?php echo route( 'cities.multi_delete' ); ?>',
                    data: {'item_ids': item_ids},
                    success: function (data) {
                        if (data > 0) {
                            window.location = '<?php echo route( 'cities.index' ); ?>';
                        } else {
                            return false;
                        }
                    }
                });
                return true;
            }
        }
    </script>
@endsection

