@extends('backend.default')
@section('extension_style')
    <meta name="csrf-token" content="{{ csrf_token() }}">
{{--    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css">--}}
{{--    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">--}}
    <link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">
@endsection
@section('content')
    <div class="container-fluid">


        <div class="card">
            <div class="card-body">
                <div style="height: 600px;">
                    <div id="fm"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extension_script')
    <script src="{{ asset('vendor/file-manager/js/file-manager.js') }}"></script>
@endsection
