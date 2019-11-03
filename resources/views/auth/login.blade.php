@extends('layouts.master_simple')
@section('title', 'BBK :: Admin | Login')
@section('content')
<div class="login-box">

    <!-- Login Logo -->
    <div class="login-logo">
        <a href="{{ url('/') }}"><img src="{{ asset('resources/assets/image/logo.png') }}"></a>
    </div>
    <!-- Login Logo -->

    <div class="login-box-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            
            <div class="form-group has-feedback{{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" id="email" name="email"  class="form-control" placeholder="Email" value="{{ old('email') }}" autocomplete="false" required autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group has-feedback{{ $errors->has('password') ? ' has-error' : '' }}">
                <input id="password" type="password" class="form-control" name="password" required placeholder="Password" autocomplete="false">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>

            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>&nbsp;&nbsp;Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <a href="{{ route('password.request') }}">I forgot my password</a><br>

    </div>
    <!-- /.login-box-body -->
</div>
@endsection


@section('custom-scripts')
<script type="text/javascript">
    jQuery(document).ready(function(){
       jQuery("body").addClass('login-page');
    });
</script>
@endsection