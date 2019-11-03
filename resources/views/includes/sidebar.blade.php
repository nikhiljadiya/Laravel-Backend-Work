<?php
$current_user = Auth::user();
$user_type = "";
$username = "";
$email = "";
$show_menu = false;
if (isset($current_user)) {
	if($current_user['type'] == "1"){
		$show_menu = true;
		$user_type = "Admin";
    }elseif($current_user['type'] == "2"){
		$user_type = "Manager";
	}elseif($current_user['type'] == "0"){
		$user_type = "User";
	}

    $username = $current_user['name'];
    $email = $current_user['email'];
}
?>
<section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel">
        <div class="pull-left image">
            <img src="{{ asset('resources/assets/image/user-placeholder.jpg') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
            <p>{{ $username }}</p>
            <a href="javascript:void(0);"><i class="fa fa-circle text-success"></i> {{ $user_type }}</a>
        </div>
    </div>

    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="active">
            <a href="{{ url('/') }}">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            </a>
        </li>
        @if($show_menu == true)
        <li class="">
            <a href="{{ url('cities') }}">
                <i class="fa fa-list"></i> <span>Cities</span>
            </a>
        </li>
        <li class="">
            <a href="{{ url('users') }}">
                <i class="fa fa-users"></i> <span>Users</span>
            </a>
        </li>
        @endif
    </ul>
</section>