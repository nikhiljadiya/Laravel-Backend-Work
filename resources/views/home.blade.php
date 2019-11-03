@extends('layouts.master')
@section('title', 'BBK :: Admin | Dashboard')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>
    <!-- Content Header (Page header) -->

    <br>
    <br>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12 col-xs-12 table-responsive">
                <table class="table table-bordered" id="timer_data">
                    <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th class="tbl-divider-bg">&nbsp;</th>
                        <th class="text-center tbl-header-bg" colspan="6">Oven Timer</th>
                        <th class="tbl-divider-bg">&nbsp;</th>
                        <th class="text-center tbl-header-bg" colspan="6">Gas Timer</th>
                    </tr>
                    <tr>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th class="tbl-divider-bg">&nbsp;</th>
                        <th class="text-center tbl-sub-header-bg" colspan="4">Active Timer in Mins</th>
                        <th class="text-center tbl-sub-header-bg" rowspan="2">Total Occupied</th>
                        <th class="text-center tbl-sub-header-bg" rowspan="2">Empty Slots</th>
                        <th class="tbl-divider-bg">&nbsp;</th>
                        <th class="text-center tbl-sub-header-bg" colspan="2">Active Timer in Mins</th>
                        <th class="text-center tbl-sub-header-bg" rowspan="2">Total Occupied</th>
                        <th class="text-center tbl-sub-header-bg" rowspan="2">Empty Slots</th>
                    </tr>
                    <tr>
                        <th class="text-center tbl-sub-header-bg">City</th>
                        <th class="text-center tbl-sub-header-bg">Outlet</th>
                        <th class="tbl-divider-bg">&nbsp;</th>
                        <th class="text-center tbl-sub-header-bg">1-5</th>
                        <th class="text-center tbl-sub-header-bg">6-10</th>
                        <th class="text-center tbl-sub-header-bg">10-20</th>
                        <th class="text-center tbl-sub-header-bg">20-30</th>
                        <th class="tbl-divider-bg">&nbsp;</th>
                        <th class="text-center tbl-sub-header-bg">1-5</th>
                        <th class="text-center tbl-sub-header-bg">6-10</th>
                    </tr>
                    </thead>
                    <tbody id="timer_data_result">
                    @foreach($timer_data as $item)
                        <tr id="outlet_{{ $item->outlet_id }}">
                            <td class="text-center">{{ $item->city }}</td>
                            <td class="text-center">{{ $item->outlet_name }}</td>
                            <td class="tbl-divider-bg">&nbsp;</td>
                            <td class="text-center">{{ $item->oven_timer_1_5 }}</td>
                            <td class="text-center">{{ $item->oven_timer_6_10 }}</td>
                            <td class="text-center">{{ $item->oven_timer_10_20 }}</td>
                            <td class="text-center">{{ $item->oven_timer_20_30 }}</td>
                            <td class="text-center">{{ $item->oven_total_occupied }}</td>
                            <td class="text-center">{{ $item->oven_empty_slots }}</td>
                            <td class="tbl-divider-bg">&nbsp;</td>
                            <td class="text-center">{{ $item->gas_timer_1_5 }}</td>
                            <td class="text-center">{{ $item->gas_timer_6_10 }}</td>
                            <td class="text-center">{{ $item->gas_total_occupied }}</td>
                            <td class="text-center">{{ $item->gas_empty_slots }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <!-- /.row -->
    </section>
    <!-- Main content -->
@endsection

@section('custom-scripts')
    <script type="text/javascript">
        jQuery(document).ready(function () {

        });
        setInterval(refreshTimerData, 10000);
        function refreshTimerData(){
            var d = new Date();
            console.log(d.toLocaleTimeString());
            jQuery.ajax({
                type: "GET",
                cache: false,
                url: '<?php echo route( 'timer_data.refresh' ); ?>',
                data: {},
                success: function (data) {
                    if (data != '') {
                        jQuery("#timer_data_result").html(data);
                    }
                }
            });
        }
    </script>
@endsection