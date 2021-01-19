@extends('layouts.default')

@section('content')
    <div class="p-3">
        <h4 class="font-size-18 text-muted mt-2 text-center">Welcome new new members !</h4>
        <p class="text-muted text-center mb-4">Change password in to continue.</p>

        <form class="form-horizontal" method="POST" action="">
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


            <div class="form-group row mt-4">
                <div class="col-sm-6 text-right">
                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">{{ __('Login') }}</button>
                </div>
            </div>

        </form>
    </div>
@endsection
