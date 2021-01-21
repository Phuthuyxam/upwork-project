@extends('Client::layouts.master')
@section('html')
    @if($currentLanguage == 'en')
        <html lang="en">
    @else
        <html lang="ar" dir="rtl">
    @endif
@endsection
@section('style')
   @if($currentLanguage == 'ar')
        <link rel="stylesheet" href="{{ asset('client/css/arab.css') }}">
   @endif
@endsection

@section('seo')
    {!! getDataSeoOption($post->id, \App\Core\Glosary\SeoConfigs::SEOTYPE['SINGLE']['KEY'], $seoDefault) !!}
@endsection
@section('content')
{{--    @dd($relatePostMetaMap)--}}
    <div class="content-wrapper">
        <section class="banner-wrapper">
            <div class="banner-image">
                @if(isset($postMetaMap[\App\Core\Glosary\MetaKey::BANNER['NAME']]) && !empty($postMetaMap[App\Core\Glosary\MetaKey::BANNER['NAME']]))
                <picture>
                    <source srcset="{{ $postMetaMap['banner'][2] }}" media="(max-width: 415px)">
                    <source srcset="{{ $postMetaMap['banner'][1] }}" media="(max-width: 768px)">
                    {!! \App\Core\Helper\FrontendHelpers::renderImage($postMetaMap['banner'][0]) !!}
                </picture>
                @endif
            </div>
            <div class="banner-content">
                <div class="banner-title">
                    @if(isset($postMetaMap[\App\Core\Glosary\MetaKey::LOGO['NAME']]))
                    {!! \App\Core\Helper\FrontendHelpers::renderImage($postMetaMap[\App\Core\Glosary\MetaKey::LOGO['NAME']]) !!}
                    @endif
                </div>
                <div class="breadscrum">
                    <ul>
                        <li class="item"><a href="{{ route('index') }}">{{__('home_title')}}</a></li>
                        @if(isset($hotelPage) && !empty($hotelPage))
                        <li class="item active">
                            <a href="{{ route('detail',$hotelPage->post_name) }}">
                                <span><div class="rectangle"></div>{{ $hotelPage->post_title }}</span>
                            </a>
                        </li>
                        @endif
                        <li class="item active"><span>
                            <div class="rectangle"></div> {{ $post->post_title }}
                        </span></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="detail-wrapper">
            <div class="container">
                <div class="detail-heading">
                    <h1 class="fw-bold">{{ $post->post_title }}</h1>
                </div>
                <div class="row">
                    <div class="col-xl-9">
                        <div class="detail-slider">
                            <div class="slider-for">
                                @if(isset($postMetaMap[App\Core\Glosary\MetaKey::SLIDE['NAME']]) && !empty($postMetaMap[App\Core\Glosary\MetaKey::SLIDE['NAME']]))
                                    @php
                                        $slides = $postMetaMap[\App\Core\Glosary\MetaKey::SLIDE['NAME']];
                                    @endphp
                                    @foreach($slides as $value)
                                        <div class="item">
                                            <div class="image-zoom">
                                                <img src="{{ asset('client/images/Group3832.svg') }}" alt="">
                                            </div>
                                            {!! \App\Core\Helper\FrontendHelpers::renderImage($value) !!}
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="slider-nav-wrapper">
                                <div class="blur-side">
                                    <div class="left">
                                        <img src="{{ asset('client/images/Rectangle901-Copy.png') }}" alt="">
                                    </div>
                                    <div class="right">
                                        <img src="{{ asset('client/images/Rectangle901.png') }}" alt="">
                                    </div>
                                </div>
                                <div class="slider-nav">
                                    @if(isset($postMetaMap[App\Core\Glosary\MetaKey::SLIDE['NAME']]) && !empty($postMetaMap[App\Core\Glosary\MetaKey::SLIDE['NAME']]))
                                        @php
                                            $slides = $postMetaMap[\App\Core\Glosary\MetaKey::SLIDE['NAME']];
                                        @endphp
                                        @foreach($slides as $value)
                                            <div class="item">
                                                {!! \App\Core\Helper\FrontendHelpers::renderImage($value) !!}
                                                <div class="overlay"></div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="detail-content">
                            <div class="description-heading">
                                <h3 class="tt-uper fw-semiBold">{{ __('detail_hotel_description') }}</h3>
                            </div>
                            <div class="description">
                                {!! $post->post_content !!}
                            </div>
                                <div class="room-type">
                                    <div class="heading">
                                        <h2 class="fw-semiBold">{{__('detail_hotel_rooms_type_inventory')}}</h2>
                                    </div>
                                    <div class="content">
                                        <div class="row">
                                            @if((isset($postMetaMap[\App\Core\Glosary\MetaKey::ROOM_TYPE['NAME']][0]->type)
                                                && !empty($postMetaMap[\App\Core\Glosary\MetaKey::ROOM_TYPE['NAME']][0]->type))
                                                ||(isset($postMetaMap[\App\Core\Glosary\MetaKey::ROOM_TYPE['NAME']][0]->inven)
                                                && !empty($postMetaMap[\App\Core\Glosary\MetaKey::ROOM_TYPE['NAME']][0]->inven)))
                                                <div class="col-xl-6 col-lg-6 col-sm-12">
                                                    <div class="type-table">
                                                            @php
                                                                $types = $postMetaMap[\App\Core\Glosary\MetaKey::ROOM_TYPE['NAME']];
                                                            @endphp
                                                        <table class="table table-bordered">
                                                            <thead>
                                                                <th>{{ __('detail_hotel_rooms_type') }}</th>
                                                                <th style="text-align: center;">{{ __('detail_hotel_inventory') }}</th>
                                                            </thead>
                                                            <tbody>
                                                            @foreach($types as $value)
                                                                <tr>
                                                                    <td>{{ $value->type }}</td>
                                                                    <td style="text-align: center;">{{ $value->inven }}</td>
                                                                </tr>
                                                            @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-xl-6 col-lg-6 col-sm-12">
                                                @if(isset($postMetaMap[\App\Core\Glosary\MetaKey::FACILITY['NAME']]) && !empty($postMetaMap[\App\Core\Glosary\MetaKey::FACILITY['NAME']][0]))
                                                    @php
                                                        $facilities = $postMetaMap[\App\Core\Glosary\MetaKey::FACILITY['NAME']];
                                                    @endphp
                                                    <div class="facilities">
                                                        <h2 class="fw-semiBold">{{__('detail_hotel_facilities')}}</h2>
                                                        <div class="facility-list">
                                                            <ul>
                                                                @foreach($facilities as $value)
                                                                    <li>
                                                                        <div class="icon">
                                                                            <img src="{{ asset('client/images/Group3811.svg') }}" alt="">
                                                                        </div>
                                                                        <p>{{ $value }}</p>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @if(isset($postMetaMap[\App\Core\Glosary\MetaKey::LOCATION['NAME']]) && !empty($postMetaMap[\App\Core\Glosary\MetaKey::LOCATION['NAME']]))
                                @php
                                    $map = $postMetaMap[\App\Core\Glosary\MetaKey::LOCATION['NAME']];
                                @endphp
                                @if($map->location->lat != '' && $map->location->long != '')
                                    <div class="map">
                                        <iframe src="https://maps.google.com/maps?q={{ $map->location->lat }}, {{ $map->location->long }}&z=15&output=embed"
                                                width="100%" height="400" frameborder="0" style="border:0"></iframe>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-3">
                        @if(isset($postMetaMap[\App\Core\Glosary\MetaKey::BOOKING_TYPE['NAME']]))
                            @include('Client::elements.booking-form',['bookingType' => $postMetaMap[\App\Core\Glosary\MetaKey::BOOKING_TYPE['NAME']]])
                        @endif
                    </div>
                    @if(isset($relatePostMetaMap) && !empty($relatePostMetaMap))
                    <div class="col-xl-9">
                        <div class="other-hotels">
                            <div class="heading">
                                <h2 class="fw-semiBold">{{__('detail_hotel_other')}}</h2>
                            </div>
                            <div class="hotels-content">
                                <div class="row">
                                    @foreach($relatePostMetaMap as $key => $value)
                                    <div class="col-xl-4 col-lg-4 col-sm-6">
                                        <div class="hotel-item">
                                            <div class="image">
                                                {!! \App\Core\Helper\FrontendHelpers::renderImage($value[\App\Core\Glosary\MetaKey::THUMBNAIL['NAME']]) !!}
                                                <div class="view-more-overlay">
                                                    <a href="{{ route('detail',$value['post_name']) }}" class="tt-uper" title="title">{{__('more_info_text')}}</a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <a href="#" title="title">
                                                    <div class="rate">
                                                        @if(isset($value['rate']))
                                                            @for($i = 0 ; $i < $value['rate']; $i++)
                                                                <i class="fas fa-star" aria-hidden="true"></i>
                                                            @endfor
                                                        @endif
                                                    </div>
                                                    <div class="title">
                                                        <h3>{{ $value['post_title'] }}</h3>
                                                        @if($value[\App\Core\Glosary\MetaKey::LOCATION['NAME']] && $value[\App\Core\Glosary\MetaKey::LOCATION['NAME']]->address != '')
                                                            <p class="city">{{ $value['location']->city }}</p>
                                                        @endif
                                                        <p class="price">{{ $value[\App\Core\Glosary\MetaKey::PRICE['NAME']] }}</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3"></div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
