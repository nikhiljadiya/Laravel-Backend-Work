@extends('layouts.master')@section('title', 'Admin | Users')
@section('content')

	<?php

	use Illuminate\Support\Facades\Input;
	?>
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Manage User </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Users</li>
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
                            <i class="fa fa-align-justify"></i><span class="break"></span> Manage User </h3>

                        <div class="pull-right box-tools">
                            <a class="btn btn-primary btn-sm" href="{{ route('users.create') }}" data-toggle="tooltip" title="Add New" data-original-title="Add New"><i class="fa fa-plus"></i></a>
                            <a class="btn btn-danger btn-sm" href="javascript:void(0);" data-toggle="tooltip" title="Remove" data-original-title="Remove" onclick="multiDelete();"><i class="fa fa-trash-o"></i></a>
                        </div>
                    </div>

                    <div class="box-body">

                        <!-- Success Message Start -->
                    @include('alerts.success')
                    <!-- Success Message End -->

                        <form action="{{ route('users.search') }}" method="post">
                            {{ csrf_field() }}
                            <div class="row">

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Type">User Type</label>
                                        <select name="type" id="type" class="form-control select2" style="width: 100%;">
                                            <option value="all" {{ (Input::get('type') == 'all') ? 'selected="selected"' : '' }}>All</option>
                                            <option value="1" {{ (Input::get('type') == '1') ? 'selected="selected"' : '' }}>Admin</option>
                                            <option value="2" {{ (Input::get('type') == '2') ? 'selected="selected"' : '' }}>Manager</option>
                                            <option value="0" {{ (Input::get('type') == '0' || Input::get('type') == null) ? 'selected="selected"' : '' }}>User</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="User Name">Name</label>
                                        <input type="text" id="name" name="name" value="{{ Input::get('name') }}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Type">City</label>
                                        <select name="city_id" id="city_id" class="form-control select2" style="width: 100%;">
                                            <option value="" {{ (Input::get('city_id') == 'all' || Input::get('city_id') == null) ? 'selected="selected"' : '' }}>All</option>
                                            @foreach($cities as $city)
                                                <option value="{{ $city->id }}" {{ (Input::get('city_id') == $city->id) ? 'selected="selected"' : '' }}>{{ $city->name }}</option>
                                            @endforeach
                                        </select>
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
                                        <!--<label for="">&nbsp;</label><br>-->
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
						$user_type_arrow = $arrow;
						$name_arrow = $arrow;
						$email_arrow = $arrow;
						$city_arrow = $arrow;
						$status_arrow = $arrow;
						$login_arrow = $arrow;

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
						$sort_url_str = route( 'users.search' ) . '?' . $query_string;

						$id_type = "asc";
						if ( Input::get( 'sort_field' ) == "users.id" ) {
							$id_type  = $sort_type;
							$id_arrow = $sort_arrow;
						}
						$id_sort_url = url( $sort_url_str . '&sort_field=users.id&sort_type=' . $id_type );

						$user_type_type = "asc";
						if ( Input::get( 'sort_field' ) == "users.type" ) {
							$user_type_type  = $sort_type;
							$user_type_arrow = $sort_arrow;
						}
						$user_type_sort_url = url( $sort_url_str . '&sort_field=users.type&sort_type=' . $user_type_type );

						$name_type = "asc";
						if ( Input::get( 'sort_field' ) == "users.name" ) {
							$name_type  = $sort_type;
							$name_arrow = $sort_arrow;
						}
						$name_sort_url = url( $sort_url_str . '&sort_field=users.name&sort_type=' . $name_type );

						$email_type = "asc";
						if ( Input::get( 'sort_field' ) == "users.email" ) {
							$email_type  = $sort_type;
							$email_arrow = $sort_arrow;
						}
						$email_sort_url = url( $sort_url_str . '&sort_field=users.email&sort_type=' . $email_type );

						$city_type = "asc";
						if ( Input::get( 'sort_field' ) == "city_name" ) {
							$city_type  = $sort_type;
							$city_arrow = $sort_arrow;
						}
						$city_sort_url = url( $sort_url_str . '&sort_field=city_name&sort_type=' . $city_type );

						$login_type = "asc";
						if ( Input::get( 'sort_field' ) == "users.is_login" ) {
							$login_type  = $sort_type;
							$login_arrow = $sort_arrow;
						}
						$login_sort_url = url( $sort_url_str . '&sort_field=users.is_login&sort_type=' . $login_type );

	                    $status_type = "asc";
	                    if ( Input::get( 'sort_field' ) == "users.status" ) {
		                    $status_type  = $sort_type;
		                    $status_arrow = $sort_arrow;
	                    }
	                    $status_sort_url = url( $sort_url_str . '&sort_field=users.status&sort_type=' . $status_type );
						?>

                        @if(Input::get('records_per_page') != "all")
                            <div class="pull-right">
                                <p>Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries</p>
                            </div>
                        @endif

                        <div class="table-responsive clearfix">
                            <table class="table table-striped table-bordered table-hover table-dark">
                                <thead>
                                <tr>
                                    <th class="chk-list-width">
                                        <input type="checkbox" id="chk_list_all" name="chk_list_all"/>
                                    </th>
                                    <th class="text-center">
                                        <a href="{{ $id_sort_url }}">ID&nbsp;<i class="{{ $id_arrow }}"></i></a>
                                    </th>
                                    <th class="text-center">
                                        <a href="{{ $user_type_sort_url }}">User Type&nbsp;<i class="{{ $user_type_arrow }}"></i></a>
                                    </th>
                                    <th class="">
                                        <a href="{{ $name_sort_url }}">Name&nbsp;<i class="{{ $name_arrow }}"></i></a>
                                    </th>
                                    <th class="">
                                        <a href="{{ $email_sort_url }}">Email&nbsp;<i class="{{ $email_arrow }}"></i></a>
                                    </th>
                                    <th class="">
                                        <a href="javascript:void(0);">Password</a></th>
                                    <th class="">
                                        <a href="{{ $city_sort_url }}">City&nbsp;<i class="{{ $city_arrow }}"></i></a>
                                    </th>
                                    <th class="text-center">
                                        <a href="{{ $login_sort_url }}">Login&nbsp;<i class="{{ $login_arrow }}"></i></a>
                                    </th>
                                    <th class="text-center">
                                        <a href="{{ $status_sort_url }}">Status&nbsp;<i class="{{ $status_arrow }}"></i></a>
                                    </th>
                                    <th class="text-center"><a href="javascript:void(0);">Action</a></th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($users as $user)
                                    <tr>
                                        <td>
                                            <input type="checkbox" id="chk_list_id_{{ $user->id }}" name="chk_list[]" value="{{ $user->id }}"/>
                                        </td>
                                        <td class="text-center">{{ $user->id }}</td>
                                        <td class="text-center">
                                            @if($user->type == "1")
                                                {{ "Admin" }}
                                            @elseif($user->type == "2")
                                                {{ "Manager" }}
                                            @else
                                                {{ "User" }}
                                            @endif
                                        </td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->password_org }}</td>
                                        <td>{{ $user->city_name }}</td>
                                        <td class="text-center">
                                            @if ($user->is_login == "1")
                                                <span class="btn bg-green btn-sm" onclick="changeLoginStatus('{{ $user->id }}', '0');"><i class="fa fa-circle text-white"></i></span>
                                            @else
                                                <span class="btn bg-black btn-sm" onclick="changeLoginStatus('{{ $user->id }}', '1');"><i class="fa fa-circle text-white"></i></span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if ($user->status == "1")
                                                <span class="btn bg-green btn-sm" onclick="changeStatus('{{ $user->id }}', '0');"><i class="fa fa-check"></i></span>
                                            @else
                                                <span class="btn bg-black btn-sm" onclick="changeStatus('{{ $user->id }}', '1');"><i class="fa fa-close"></i></span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a class="btn btn-primary btn-sm" href="{{ route('users.edit', [$user->id]) }}" data-toggle="tooltip" title="Edit User" data-original-title="Edit User">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <form action="{{ route('users.destroy', [$user->id]) }}" method="POST" style="display: inline;">
                                                <input type="hidden" name="_method" value="DELETE">
                                                {{ csrf_field() }}
                                                <button type="submit" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Remove User" data-original-title="Remove User">
                                                    <i class="fa fa-trash-o"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">No Users Found.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="box-footer clearfix">
                        @if(Input::get('records_per_page') != "all")
                            <div class="pull-right">
                                {!! $users->links() !!}
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
                    url: '<?php echo route( 'users.multi_delete' ); ?>',
                    data: {'item_ids': item_ids},
                    success: function (data) {
                        if (data > 0) {
                            window.location = '<?php echo route( 'users.index' ); ?>';
                        } else {
                            return false;
                        }
                    }
                });
                return true;
            }
        }

        function changeStatus(item_id, status) {
            if (item_id == "") {
                return false;
            }
            $.ajax({
                type: "GET",
                url: '<?php echo route( 'users.change_status' ); ?>',
                data: {'item_id': item_id, 'status': status},
                success: function (data) {
                    if (data > 0) {
                        window.location = '<?php echo route( 'users.index' ); ?>';
                    } else {
                        return false;
                    }
                }
            });
        }

        function changeLoginStatus(item_id, status) {
            if (item_id == "") {
                return false;
            }
            $.ajax({
                type: "GET",
                url: '<?php echo route( 'users.change_login_status' ); ?>',
                data: {'item_id': item_id, 'status': status},
                success: function (data) {
                    if (data > 0) {
                        window.location = '<?php echo route( 'users.index' ); ?>';
                    } else {
                        return false;
                    }
                }
            });
        }
    </script>
@endsection

