@extends('layouts.master')@section('title', 'BBK :: Admin | Timer Data')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Timer Data
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Timer Data</li>
        </ol>
    </section>
    <!-- Content Header (Page header) -->

    <br>
    <br>

    <!-- Main content -->
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-12 col-xs-12">
                <table class="table table-bordered" id="timer_data">
                    <thead>
                    <tr>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th>&nbsp;</th>
                        <th colspan="4">Active Timer in Mins</th>
                        <th rowspan="2">Total Occupied</th>
                        <th rowspan="2">Empty Slots</th>
                        <th>&nbsp;</th>
                        <th colspan="4">Active Timer in Mins</th>
                        <th rowspan="2">Total Occupied</th>
                        <th rowspan="2">Empty Slots</th>
                    </tr>
                    <tr>
                        <th>City</th>
                        <th>Outlet</th>
                        <th>&nbsp;</th>
                        <th>1-5</th>
                        <th>6-10</th>
                        <th>10-20</th>
                        <th>20-30</th>
                        <th>&nbsp;</th>
                        <th>1-5</th>
                        <th>6-10</th>
                        <th>10-20</th>
                        <th>20-30</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($timer_data as $item)
                        <tr id="outlet_{{ $item->outlet_id }}">
                            <td>{{ $item->city }}</td>
                            <td>{{ $item->outlet_name }}</td>
                            <td>&nbsp;</td>
                            <td>{{ $item->oven_timer_1_5 }}</td>
                            <td>{{ $item->oven_timer_6_10 }}</td>
                            <td>{{ $item->oven_timer_10_20 }}</td>
                            <td>{{ $item->oven_timer_20_30 }}</td>
                            <td>{{ $item->oven_total_occupied }}</td>
                            <td>{{ $item->oven_empty_slots }}</td>
                            <td>&nbsp;</td>
                            <td>{{ $item->gas_timer_1_5 }}</td>
                            <td>{{ $item->gas_timer_6_10 }}</td>
                            <td>{{ $item->gas_timer_10_20 }}</td>
                            <td>{{ $item->gas_timer_20_30 }}</td>
                            <td>{{ $item->gas_total_occupied }}</td>
                            <td>{{ $item->gas_empty_slots }}</td>
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
        /*setInterval(refreshTimerData, 1000);*/
        function refreshTimerData(){
            /*var d = new Date();
            console.log(d.toLocaleTimeString());*/
            jQuery.ajax({
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
        }
    </script>
@endsection