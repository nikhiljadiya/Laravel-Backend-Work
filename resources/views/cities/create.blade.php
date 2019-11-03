@extends('layouts.master')
@section('title', 'Admin | Add City')
@section('content')

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Add City
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ url('/') }}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{ url('cities') }}"><i class="fa fa-list"></i> Citys</a></li>
        <li class="active">Add City</li>
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
                        <span class="break"></span> Add City
                    </h3>

                    <div class="pull-right box-tools">
                        <a href="{{ url('cities') }}" class="btn btn-danger btn-sm" data-toggle="tooltip" title="Close" data-original-title="Close">
                            <i class="fa fa-remove"></i>
                        </a>
                    </div>
                </div>

                <div class="box-body">

                    <!-- Error Message Start -->
                    @include('alerts.error')
                    <!-- Error Message End -->

                    <form class="form-horizontal" action="{{ route('cities.store') }}" id="add_occupation_form" name="add_occupation_form" method="POST">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Name <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" id="name" name="name" value="" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <div class="col-sm-offset-4 col-sm-2">
                                    <button type="submit" id="btnsubmit" name="btnsubmit" class="btn btn-primary">Save</button>
                                </div>
                                <div class="col-sm-2">
                                    <button type="reset" id="btncancel" name="btncancel" class="btn" onclick="window.location.href = '<?php echo route('cities.index'); ?>'">Cancel</button>
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
