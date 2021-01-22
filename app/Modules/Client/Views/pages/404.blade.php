@extends('Client::layouts.master')
@section('title')
    404 - Not found
@endsection
@section('style')
    <style>
        body {
            height: 100vh;
        }
        .banner-wrapper {
            height: 100vh;
            background-size: cover;
            max-height: unset;
            background-position: center;
        }
        footer {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="banner-wrapper" style="background-image: url({{asset('client/images/MaskGroup2.jpg')}})">
            <div class="banner-content">
                <div class="banner-title" style="text-align: center">
                    <h1 style="font-size: 200px">404</h1>
                    <h2>Not found</h2>
                </div>
                <div class="breadscrum">
                    <a href="{{ route('index') }}">Back to Home</a>
                </div>
            </div>
        </section>
    </div>
@endsection
