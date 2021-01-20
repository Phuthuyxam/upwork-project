@extends('layouts.default')

@section('content')
    <div class="p-3">
        <h4 class="font-size-18 text-muted mt-2 text-center">Welcome new new members !</h4>
        <p class="text-muted text-center mb-4">Change password in to continue.</p>

        <form class="form-horizontal" method="POST" action="">
            @csrf
            <div class="form-group">
                <label for="username">{{ __('Change password') }}</label>
                <input id="password" type="password" class="form-control @error('email') is-invalid @enderror" name="password" value="{{ old('password') }}" required autocomplete="password" autofocus>
                @error('password')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="username">{{ __('Confirm password') }}</label>
                <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}" required autocomplete="password_confirmation" autofocus>
                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group row mt-4">
                <div class="col-sm-6">
                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">{{ __('Save New Password') }}</button>
                </div>
            </div>

        </form>
    </div>
@endsection
