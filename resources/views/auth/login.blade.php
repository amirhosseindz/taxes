@extends('layouts.login')

@section('content')
<div class="login-box">
    <div class="login-logo">
        {{ config('app.name') }}
    </div><!-- /.login-logo -->
    <div class="login-box-body">
        <p class="login-box-msg">Sign In</p>
        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group has-feedback @error('email') has-error @enderror">
                <input id="email" type="email" name="email" class="form-control" placeholder="{{ __('E-Mail Address') }}" value="{{ old('email') }}" required autocomplete="email" autofocus>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                @error('email')
                    <span class="help-block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group has-feedback @error('password') has-error @enderror">
                <input id="password" type="password" name="password" class="form-control" placeholder="{{ __('Password') }}" required autocomplete="current-password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                @error('password')
                    <span class="help-block">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}> {{ __('Remember Me') }}
                        </label>
                    </div>
                </div><!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-sign-in"></i> {{ __('Login') }}</button>
                </div><!-- /.col -->
            </div>
        </form>

        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}">{{ __('Forgot Your Password?') }}</a><br>
        @endif

        No Account? <a href="{{ route('register') }}">Create One</a><br>

    </div><!-- /.login-box-body -->
</div><!-- /.login-box -->
@endsection
