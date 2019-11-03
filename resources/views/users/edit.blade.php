@extends('layouts.master')
@section('title', 'Admin | Edit User')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Edit User
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('users') }}"><i class="fa fa-users"></i> Users</a></li>
        <li class="active">Edit User</li>
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
                        <i class="fa fa-edit"></i>
                        <span class="break"></span> Edit User
                    </h3>

                    <div class="pull-right box-tools">
                        <a href="{{ url('users') }}" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Close" data-original-title="Close">
                            <i class="fa fa-remove"></i>
                        </a>
                    </div>
                </div>

                <div class="box-body">

                    <!-- Error Message Start -->
                    @include('alerts.error')
                    <!-- Error Message End -->

                    <form class="form-horizontal" action="{{ route('users.update', $user->id) }}" id="edit_user_form" name="edit_user_form" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="_method" value="PUT">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="user_type">User Type <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select name="type" id="type" onchange="showUsers(this);" class="form-control select2" style="width: 100%;" required>
                                    <option value="">Select</option>
                                    <option value="1" {{ ($user->type == '1') ? 'selected="selected"' : '' }}>Admin</option>
                                    <option value="2" {{ ($user->type == '2') ? 'selected="selected"' : '' }}>Manager</option>
                                    <option value="0" {{ ($user->type == '0') ? 'selected="selected"' : '' }}>User</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="users_list" style="{{ ($user->type == '2') ? '' : 'display: none' }}">
                            <label class="control-label col-sm-2" for="user_type">Users
                                <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select name="user_ids[]" id="user_ids" class="form-control select2" style="width: 100%;" multiple {{ ($user->type == '2') ? 'required' : '' }}>
                                    @foreach($users as $item)
                                        <option value="{{ $item->id }}" {{ (in_array($item->id, $manager_users_array)) ? 'selected="selected"' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
		                    <?php /*<div class="col-sm-4">
                                    <label class="col-sm-12">
                                        <input type="checkbox" name="chk_all" id="chk_all" value="1" class="minimal">&nbsp;&nbsp;Select All
                                    </label>
                                </div>*/ ?>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Name <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" id="name" name="name" value="{{ $user->name }}" class="form-control" required>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="username">Username <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" id="username" name="username" value="{{ $user->username }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Email <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="email" id="email" name="email" value="{{ $user->email }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="password">Password</label>
                            <div class="col-sm-4">
                                <input type="text" id="password" name="password" value="{{ $user->password_org }}" class="form-control" autocomplete="off">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="occupation">City <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select name="city_id" id="city_id" class="form-control select2" required>
                                    <option value="">Select</option>
                                    @foreach($cities as $city)
                                        <option value="{{ $city->id }}" {{ ($user->city_id == $city->id) ? 'selected="selected"' : '' }}>{{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 text-right" for="status">Status</label>
                            <div class="col-sm-4">
                                <label class="col-sm-4">
                                    <input type="radio" name="status" value="1" class="minimal"  {{ ($user->status == '1') ? 'checked="checked"' : '' }}>&nbsp;&nbsp;Active
                                </label>
                                <label class="col-sm-4">
                                    <input type="radio" name="status" value="0" class="minimal" {{ ($user->status == '0') ? 'checked="checked"' : '' }}>&nbsp;&nbsp;Inactive
                                </label>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <div class="col-sm-offset-4 col-sm-2">
                                    <button type="submit" id="btnsubmit" name="btnsubmit" class="btn btn-primary">Save</button>
                                </div>
                                <div class="col-sm-2">
                                    <button type="reset" id="btncancel" name="btncancel" class="btn" onclick="window.location.href = '<?php echo route('users.index'); ?>'">Cancel</button>
                                </div>
                            </div>
                        </div>

                    </form>
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

            /*jQuery(".icheckbox_square-blue > #chk_all").on('ifChanged', function (e) {
                var checkbox = document.getElementsByName('chk_all');
                var checkValue = jQuery(this).iCheck('update')[0].checked;
                if (checkValue) {
                    checkbox.checked = true;
                    jQuery('#users_list option').prop('selected', true);
                } else {
                    checkbox.checked = false;
                    jQuery('#users_list option').prop('selected', false);
                }
            });*/
        });

        function showUsers(select_user_type) {
            if (jQuery(select_user_type).val() == "2") {
                jQuery("#users_list").show();
                jQuery('#user_ids').attr('required', 'required');
            } else {
                jQuery("#users_list").hide();
                jQuery('#user_ids').removeAttr('required');
            }
        }
    </script>
@endsection
