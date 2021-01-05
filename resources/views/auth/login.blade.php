@extends('layouts.default')

@section('content')
    <div class="p-3">
        <h4 class="font-size-18 text-muted mt-2 text-center">Welcome Back !</h4>
        <p class="text-muted text-center mb-4">Sign in to continue to Fonik.</p>

        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="username">{{ __('E-Mail Address') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group row mt-4">
                <div class="col-sm-6">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" name="remember" id="customControlInline" {{ old('remember') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="customControlInline">Remember me</label>
                    </div>
                </div>
                <div class="col-sm-6 text-right">
                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">{{ __('Login') }}</button>
                </div>
            </div>

            <div class="form-group mb-0 row">
                <div class="col-12 mt-4">
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-muted"><i class="mdi mdi-lock"></i> {{ __('Forgot Your Password?') }}</a>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection
@section('route')
    <p>Don't have an account ? <a href="{{ route('register') }}" class="font-weight-bold text-primary"> Signup Now </a> </p>
@endsection
