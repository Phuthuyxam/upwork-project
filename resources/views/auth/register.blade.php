@extends('layouts.default')

@section('content')
    <div class="p-3">
        <h4 class="font-size-18 text-muted mt-2 text-center">Register</h4>
{{--        <p class="text-muted text-center mb-4">Get your free fonik account now.</p>--}}

        <form class="form-horizontal" method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">{{ __('Name') }}</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">{{ __('E-Mail') }}</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

{{--            <div class="form-group">--}}
{{--                <label for="username">Username</label>--}}
{{--                <input type="text" class="form-control" id="username" placeholder="Enter username">--}}
{{--            </div>--}}

            <div class="form-group">
                <label for="password">{{ __('Password') }}</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="confirm-password">{{ __('Confirm Password') }}</label>
                <input id="confirm-password" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
            </div>

            <div class="form-group row mt-4">
                <div class="col-12 text-right">
                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Register</button>
                </div>
            </div>

{{--            <div class="form-group mt-4 mb-0 row">--}}
{{--                <div class="col-12">--}}
{{--                    <p class="text-muted mb-0">By registering you agree to the Fonik <a href="#">Terms of Use</a></p>--}}
{{--                </div>--}}
{{--            </div>--}}
        </form>
    </div>
@endsection
@section('route')
    <p>Already have an account ? <a href="{{ route('login') }}" class="font-weight-bold text-primary"> Login </a> </p>
@endsection
