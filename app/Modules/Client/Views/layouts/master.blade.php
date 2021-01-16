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
    <script type="application/ld+json" class="schema-graph">
        {"@context":"https://schema.org","@graph":[{"@type":"WebSite","@id":"{{url()->to("/")}}/#website","url":"{{ url()->to("/") }}","name":"{{$systemConfig['site_title']}}","description":"{{ $systemConfig['site_tagline'] }}","potentialAction":[{"@type":"SearchAction","target":"","query-input":"required name="}],"inLanguage":"en-US"},{"@type":"ImageObject","@id":"{{ url()->to("/") }}/#primaryimage","inLanguage":"en-US","url":"{{ $systemConfig['logo'] }}","width":350,"height":108},{"@type":"WebPage","@id":"{{ url()->to("/") }}/#webpage","url":"{{ url()->to("/") }}","name":"{{ $systemConfig['site_title'] }}","isPartOf":{"@id":"{{ url()->to('/') }}/#website"},"primaryImageOfPage":{"@id":"{{ url()->to("/") }}/#primaryimage"},"datePublished":"2021-01-05T06:39:17+00:00","dateModified":"2021-01-05T06:39:17+00:00","inLanguage":"en-US","potentialAction":[{"@type":"ReadAction","target":["{{ url()->to("/") }}"]}]}]}
    </script>
    <link rel="stylesheet" href="{{ asset('client/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/animate.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('client/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('client/css/style.css') }}">
    @yield('style')
</head>

<body>
@include('Client::elements.header')


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

</body>

</html>
