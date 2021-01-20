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
    {!! getDataSeoOption(\App\Core\Glosary\SeoConfigs::SEOPAGEFIXED['HOMEPAGE']['FIXID'], \App\Core\Glosary\SeoConfigs::SEOTYPE['SINGLE']['KEY'], $seoDefault) !!}
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="home-slider-wrapper">
            @if( isset($page->slider) && !empty($page->slider))
                @if($page->slider[0]->logo != null && $page->slider[0]->desc != null && $page->slider[0]->banner_desktop != null && $page->slider[0]->banner_tablet != null && $page->slider[0]->banner_mobile != null)
                    <div class="home-slider">
                        @foreach($page->slider as $item)
                            <div class="item">
                                <div class="slide-item-content">
                                    <div class="slide-logo">
                                        {!! \App\Core\Helper\FrontendHelpers::renderImage($item->logo) !!}
                                    </div>
                                    <div class="slide-description">
                                        <p>{{ $item->desc }}</p>
                                    </div>
                                </div>
                                <picture>
                                    <source srcset="{{ $item->banner_mobile }}" media="(max-width: 414px)">
                                    <source srcset="{{ $item->banner_tablet }}" media="(max-width: 768px)">
                                    {!! \App\Core\Helper\FrontendHelpers::renderImage($item->banner_desktop) !!}
                                </picture>
                            </div>
                        @endforeach
                    </div>
                    <div class="slide-counter">
                        <div class="container">
                            <span id="counter-number">01</span>
                            <span>of</span>
                            <span>{{ count($page->slider) > 10 ? count($page->slider) : '0'.count($page->slider) }}</span>
                        </div>
                    </div>
                @endif
            @endif
            <div class="hotel-search-wrapper">
                <form action="">
                    <div class="hotel-search-content">
                        <div class="hotel-selection search-item">
                            <p class="title tt-uper fw-bold">{{__('home_find_hotel')}}</p>
                            <div class="hotel-select">
                                <div class="select-arrow">
                                    <img src="{{ asset('client/images/Path6702.png') }}" alt="">
                                </div>
                                <select class="form-control" required="required">
                                    <option value="default">{{__('home_select_hotel')}}</option>
                                    <option value="">The Venue</option>
                                    <option value="">Frontel</option>
                                    <option value="">Three points hotel</option>
                                </select>
                            </div>
                        </div>
                        <div class="check-in-out-date search-item">
                            <div class="check-in">
                                <p class="title tt-uper fw-bold">{{__('home_check_in')}}</p>
                                <p class="date fw-semiBold">20</p>
                                <p class="title month-year tt-uper fw-semiBold">dec 2020</p>
                                <input type="text" class="date-picker start-date form-control" name="start-date" readonly>
                            </div>
                            <div class="angle-left">
                                @if($currentLanguage == 'ar')
                                    <img src="{{ asset('client/images/Path6701-Copy.png') }}" alt="Path6701">
                                @else
                                    <img src="{{ asset('client/images/Path6701.png') }}" alt="Path6701">
                                @endif
                            </div>
                            <div class="check-out">
                                <p class="title tt-uper fw-bold">{{__('home_check_out')}}</p>
                                <p class="date fw-semiBold">22</p>
                                <p class="title month-year tt-uper fw-semiBold">dec 2020</p>
                                <input type="text" class="date-picker end-date form-control" name="end-date" readonly>
                            </div>
                        </div>
                        <div class="occupancy search-item">
                            <p class="title tt-uper fw-bold">{{__('home_occupancy')}}</p>
                            <div class="occupancy-detail">
                                <div class="adult-select">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <select class="form-control" name="adult">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3" selected>3</option>
                                        <option value="4">4</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                                <div class="children-select">
                                    <i class="fa fa-male" aria-hidden="true"></i>
                                    <select class="form-control" name="child">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3" selected>3</option>
                                        <option value="4">4</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="promotion-code search-item">
                            <p class="title fw-bold">{{__('home_promotion_code')}}</p>
                            <input type="text" class="form-control">
                        </div>
                        <div class="btn-submit-wrapper">
                            <input type="submit" class="btn btn-check-available tt-uper fw-bold" value="{{__('home_check_availability')}}">
                        </div>
                    </div>
                </form>
            </div>
        </section>
        @if(isset($page->our_service) && !empty($page->our_service))
            <section class="home-service-wrapper">
                @if($page->our_service->background != null)
                <div class="home-service-background">
                    {!! \App\Core\Helper\FrontendHelpers::renderImage($page->our_service->background) !!}
                </div>
                @endif
                <div class="container">
                    <div class="home-service-content">
                        <div class="home-service-intro" style="background-image: url({{ asset('client/images/MaskGroup14.jpg') }});">
                            <div class="home-service">
                                @if($page->our_service->title != null)
                                    <h2 class="tt-uper fw-bold">{{ $page->our_service->title }}</h2>
                                @endif
                                @if($page->our_service->heading != null)
                                    <h3 class="fw-semiBold">{{ $page->our_service->heading }}</h3>
                                @endif
                                {!! $page->our_service->paragraph !!}
                                @if($page->our_service->url != null)
                                    <a href="{{ $page->our_service->url }}" class="btn-view-more" title="title">
                                        <div class="diamond">
                                            <i class="fas fa-long-arrow-alt-right"></i>
                                        </div>
                                        <span class="tt-uper">{{ __('see_more_services') }}</span>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif
        @if(isset($page->our_hotel) && !empty($page->our_hotel))
            <section class="home-hotel-wrapper">
            <div class="container">
                <div class="home-hotel-heading">
                    <div class="heading">
                        @if($page->our_hotel->title != null)
                            <h3 class="tt-uper">{{ $page->our_hotel->title }}</h3>
                        @endif
                        @if($page->our_hotel->heading)
                            <h2 class="tt-uper fw-bold">{{ $page->our_hotel->heading }}</h2>
                        @endif
                    </div>
                    @if($page->our_hotel->url != null)
                        <div class="view-more-detail">
                            <a href="{{ $page->our_hotel->url }}" class="btn-view-more" title="title">
                                <div class="diamond">
                                    <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
                                </div>
                                <span class="tt-uper">{{ __('see_more_details')  }}</span>
                            </a>
                        </div>
                    @endif
                </div>
                @if(isset($postMap) && !empty($postMap))
                    <div class="home-hotel-content">
                        <div class="row">
                            @foreach($postMap as $item)
                                <div class="col-xl-3 col-lg-3 col-sm-6">
                                <a href="{{ route('detail',$item['slug']) }}" title="title">
                                    <div class="home-hotel-item">
                                        <div class="image">
                                            {!! \App\Core\Helper\FrontendHelpers::renderImage($item[\App\Core\Glosary\MetaKey::THUMBNAIL['NAME']]) !!}
                                        </div>
                                        <div class="overlay">
                                            <div class="logo">
                                                {!! \App\Core\Helper\FrontendHelpers::renderImage($item[\App\Core\Glosary\MetaKey::LOGO['NAME']]) !!}
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>
        @endif
        @if(isset($page->message) && !empty($page->message))
            <section class="home-quote-wrapper">
                <div class="home-service-background">
                    {!! \App\Core\Helper\FrontendHelpers::renderImage($page->message->background) !!}
                </div>
                <div class="container">
                    <div class="home-service-content">
                        <div class="home-service-intro" style="background-image: url({{ asset('client/images/MaskGroup14.jpg') }});">
                            <div class="home-service">
                                <h2 class="tt-uper fw-bold">{{ $page->message->title }}</h2>
                                <p>
                                    {{ $page->message->paragraph }}
                                </p>
                                @if($page->message->author != '' && $page->message->avatar != '' && $page->message->sign != '')
                                    <div class="author-wrapper">
                                        <div class="author-detail">
                                            <div class="author-image">
                                                {!! \App\Core\Helper\FrontendHelpers::renderImage($page->message->avatar) !!}
                                            </div>
                                            <div class="author-name">
                                                <p>{{ $page->message->author }}</p>
                                            </div>
                                        </div>
                                        <div class="author-sign">
                                            {!! \App\Core\Helper\FrontendHelpers::renderImage($page->message->sign) !!}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        @endif

        {{-- brand client show --}}
{{--        @dd($page->our_brand)--}}
        @if(isset($page->our_brand) && !empty($page->our_brand))
            @php
                $brands = $page->our_brand;
            @endphp
            <section class="brand-wrapper">
                <div class="container">
                    <div class="home-hotel-heading" style="display: block;">
                        <div class="heading">
                            @if(isset($brands->heading) && !empty($brands->heading))
                            <h3 class="tt-uper">{{ $brands->heading }}</h3>
                            @endif
                            @if(isset($brands->title) && !empty($brands->title))
                                <h2 class="tt-uper fw-bold">{{ $brands->title }}</h2>
                            @endif
                        </div>
                    </div>
                    <div class="brand-content">
                        @if(isset($brands->brands) && !empty($brands->brands))
                            @if($brands->brands[0]->banner != null)
                                <div class="brand-slider">
                                    @foreach($brands->brands as $brand)
                                        @if($brand->banner != '')
                                            <div class="item">
                                                <a href="{{ $brand->url }}">
                                                    {!! \App\Core\Helper\FrontendHelpers::renderImage($brand->banner) !!}
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </section>
        @endif


        <section class="map-wrapper">
            <div class="location-search-wrapper">
                <div class="search-input">
                    <input id="search" type="text" class="form-control" placeholder="">
                </div>
                <div class="search-icon">
                    <i class="fa fa-search" aria-hidden="true"></i>
                </div>
            </div>
            <div class="location-detail-wrapper" id="location">
                <a href="#" class="close">x</a>
                <div class="location-detail-content">
                    <div class="location-image">
                        <img src="" alt="">
                    </div>
                    <div class="location-detail">
                        <p class="name"></p>
                        <p class="city"></p>
                        <p class="rate"></p>
                    </div>
                </div>
            </div>
            <div id="infowindow-content" class="d-none">
                <span id="place-name" class="title">ad</span><br />
                <strong>Place ID:</strong> <span id="place-id">ad</span><br />
                <span id="place-address">ad</span>
            </div>
            <div class="zoom-control-wrapper">
                <div class="zoom-controls">
                    <div class="plus">+</div>
                    <div class="zoom-bar">
                        <div class="zoom-level" style="height:70%"></div>
                    </div>
                    <div class="minus">-</div>
                </div>
            </div>
            <div id="map"></div>
        </section>
    </div>
@endsection
@section('script')
    <script>
        const locations = JSON.parse('{!!  json_encode($mapData) !!}');
        function initMap() {
            const maxZoom = 15;
            const minZoom = 3;
            var zoom = 4;
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: zoom,
                center: locations != '' ? locations[0].location : { lat: -28.024, lng: 140.887 },
                mapTypeControlOptions: { mapTypeIds: [] },
                fullscreenControl: false,
                streetViewControl: false,
                maxZoom: maxZoom,
                minZoom: minZoom,
                zoomControl: false
            });

            google.maps.event.addListener(map, 'zoom_changed', function () {
                zoom = map.getZoom();
                var height = (zoom - minZoom) / (maxZoom - minZoom) * 100 + '%';
                $('.zoom-controls').find('.zoom-level').height(height);
            });

            const input = document.getElementById("search");
            const searchBox = new google.maps.places.SearchBox(input);
            const infowindow = new google.maps.InfoWindow();
            const infowindowContent = document.getElementById("infowindow-content");


            map.addListener("bounds_changed", () => {
                searchBox.setBounds(map.getBounds());
            });

            searchBox.addListener("places_changed", () => {
                const places = searchBox.getPlaces();
                if (places.length == 0) {
                    return;
                }

                // For each place, get the icon, name and location.
                const bounds = new google.maps.LatLngBounds();
                places.forEach((place) => {
                    if (!place.geometry) {
                        console.log("Returned place contains no geometry");
                        return;
                    }

                    if (place.geometry.viewport) {
                        // Only geocodes have viewport.
                        bounds.union(place.geometry.viewport);
                    } else {
                        bounds.extend(place.geometry.location);
                    }
                });
                map.fitBounds(bounds);
                map.setZoom(maxZoom);

            });

            const markers = locations.map((location, i) => {
                var marker = new google.maps.Marker({
                    position: location.location,
                    icon: "{{ asset('client/images/Group 3219.png') }}",
                    map: map
                });

                marker.addListener("click", () => {
                    if ($(window).width() < 600) {
                        html = `
                    <p class="fw-bold">`+ location.name + `</p>
                    <p>`+ location.address + `</p>
                    <p>`+ location.city + `</p>
                `;
                        infowindow.setContent(html);
                        infowindow.open(map, marker);
                    } else {
                        map.setZoom(maxZoom);
                        map.setCenter(marker.getPosition());

                        var rate = "";
                        var star = '<i class="fas fa-star"></i>';
                        for (var i = 0; i < location.rate; i++) {
                            rate += star;
                        }
                        $('#location').show();
                        $('#location').addClass('animate__animated');
                        $('#location').addClass('animate__slideInLeft');
                        $('#location').removeClass('animate__slideOutLeft');
                        $('#location').find('img').attr('src', location.image);
                        $('#location').find('.name').text(location.name);
                        $('#location').find('.city').text(location.city);
                        $('#location').find('.rate').html(rate);
                    }
                });
            });
            $('.zoom-controls .zoom-level').height((zoom - minZoom) / (maxZoom - minZoom) * 100 + '%');
            $('.zoom-controls .plus').click(function () {
                if (zoom < maxZoom) {
                    zoom = zoom + 1;
                    map.setZoom(zoom);
                    var height = (zoom - minZoom) / (maxZoom - minZoom) * 100 + '%';
                    $(this).parents('.zoom-controls').find('.zoom-level').height(height);
                } else {
                    zoom = maxZoom;
                }
            })

            $('.zoom-controls .minus').click(function () {
                if (zoom > minZoom) {
                    zoom = zoom - 1;
                    map.setZoom(zoom);
                    var height = (zoom - minZoom) / (maxZoom - minZoom) * 100 + '%';
                    $(this).parents('.zoom-controls').find('.zoom-level').height(height);
                } else {
                    zoom = minZoom;
                }
            })
        }
    </script>
@endsection
