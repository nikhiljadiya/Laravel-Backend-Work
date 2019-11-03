@extends('layouts.master_simple')
@section('title', 'InstaKoin :: Admin | Reset Password')
@section('content')
<div class="login-box">

    <!-- Login Logo -->
    <div class="login-logo">
        <a href="{{ url('/') }}"><img src="{{ asset('resources/assets/image/logo.png') }}"></a>
    </div>
    <!-- Login Logo -->

    <div class="login-box-body">
        <p class="login-box-msg">Reset Password</p>

        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            {{ csrf_field() }}

            <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" id="email" name="email" class="form-control" placeholder="Email" value="{{ old('email') }}" autocomplete="false" required autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>

            <div class="row">
                <!-- /.col -->
                <div class="col-xs-8">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Send Password Reset Link</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

    </div>
    <!-- /.login-box-body -->
</div>
@endsection


@section('custom-scripts')
<script type="text/javascript">
    jQuery(document).ready(function () {
        jQuery("body").addClass('login-page');
    });
</script>
@endsection