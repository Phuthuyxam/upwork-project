@php
    $menusData  = OptionHelpers::getOptionByKey(\App\Core\Glosary\OptionMetaKey::MENU['VALUE']);
    $systemConfig = OptionHelpers::getSystemConfigByKey('general');
    if($systemConfig && json_decode($systemConfig,true))
        $systemConfig = json_decode($systemConfig, true);
    if($menusData && json_decode($menusData, true))
        $menus = json_decode($menusData,true);
@endphp
<!DOCTYPE html>
@yield('html')

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    @yield('seo')
    @yield('schema')
    <link rel="stylesheet" href="{{ asset('client/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/animate.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('client/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/style.css') }}">
    <style>
        #loading {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 99999;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        #loading img{
            width: 20%;
        }
    </style>
    @yield('style')
</head>

<body>
@include('Client::elements.header')

<div id="loading">
    <img src="{{ asset('client/images/loading.gif') }}" alt="">
</div>
{{-- Content of page--}}
@yield('content')

@include('Client::elements.footer')
<script defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTq2v6wtkzEb5ekaGZiVvDW3G64dQ0rvc&callback=initMap&libraries=places"></script>
<script src="{{ asset('client/js/jquery.min.js') }} "></script>
<script src="{{ asset('client/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('client/js/slick.min.js') }}"></script>
<script src="{{ asset('client/js/jquery.lazy.min.js') }}"></script>
<script src="{{ asset('client/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('client/js/jquery.fancybox.min.js') }}"></script>
<script src="{{ asset('client/js/custom.js') }}"></script>
@yield('script')
<script>
    $(document).ready(function (){
        setTimeout(function (){
            $('#loading').hide();
        },2000)
    })
</script>
</body>

</html>
