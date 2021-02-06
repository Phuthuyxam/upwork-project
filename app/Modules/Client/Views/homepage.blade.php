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
                <form action="https://bookcore.backhotelengine.com/redirect-avail/" id="bookingForm" method="post">
                    <input type="hidden" name="partner">
                    <input type="hidden" name="lang" value="{{ $currentLanguage }}">
                    <div class="hotel-search-content">
                        <div class="hotel-selection search-item">
                            <p class="title tt-uper fw-bold">{{__('home_find_hotel')}}</p>
                            <div class="hotel-select">
                                <div class="select-arrow">
                                    <img src="{{ asset('client/images/Path6702.png') }}" alt="">
                                </div>
                                <select class="form-control" id="hotel_code" name="hotel_code" style="padding-right: 2rem" required="required">
                                    <option value="-1">{{__('home_select_hotel')}}</option>
                                    @if(isset($hotel_codes) && !empty($hotel_codes))
                                        @foreach($hotel_codes as $value)
                                            <option value="{{ $value['code'] }}"> {{ $value['name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <p class="error text-danger fw-bold" style="font-size: 12px;display: none; margin-top: .5rem">Please choose hotel</p>
                        </div>
                        <div class="check-in-out-date search-item">
                            <div class="check-in">
                                <p class="title tt-uper fw-bold">{{__('home_check_in')}}</p>
                                <p class="date fw-semiBold">{{ date('d') }}</p>
                                <p class="title month-year tt-uper fw-semiBold">{{ date('M Y') }}</p>
                                <input type="text" class="date-picker start-date form-control" id="arrival" name="arrival" readonly value="{{ date('Y-m-d') }}">
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
                                <p class="date fw-semiBold">{{ date('d',strtotime(' +1 day')) }}</p>
                                <p class="title month-year tt-uper fw-semiBold">{{ date('M Y',strtotime(' +1 day')) }}</p>
                                <input type="text" class="date-picker end-date form-control" id="departure" name="departure" readonly value="{{ date('Y-m-d',strtotime('+1 day')) }}">
                            </div>
                        </div>
                        <div class="occupancy search-item">
                            <p class="title tt-uper fw-bold">{{__('home_occupancy')}}</p>
                            <div class="occupancy-detail">
                                <div class="occupancy-item" data-toggle="modal" data-target="#occupancyModal" data-backdrop="static" data-keyboard="false">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span id="adults">1</span>
                                </div>
                                <div class="occupancy-item" data-toggle="modal" data-target="#occupancyModal" data-backdrop="static" data-keyboard="false">
                                    <i class="fa fa-male" aria-hidden="true"></i>
                                    <span id="children">0</span>
                                </div>
                                <input type="hidden" id="occupancies" name="occupancies">
                            </div>
                        </div>
                        <div class="promotion-code search-item">
                            <p class="title fw-bold">{{__('home_promotion_code')}}</p>
                            <input type="text" class="form-control" name="codpromo">
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
                                <h3 class="tt-uper fw-bold" style="font-size: 40px;">{{ $brands->heading }}</h3>
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
                                                <a href="{{ $brand->url ? $brand->url : 'javascript:void(0)'}}">
                                                    <div class="image">
                                                        {!! \App\Core\Helper\FrontendHelpers::renderImage($brand->banner) !!}
                                                    </div>
                                                    <p class="name fw-bold">{{ isset($brand->name) && !empty($brand->name) ? $brand->name : '' }}</p>
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
        @if(isset($page->coming_brand) && !empty($page->coming_brand))
            @php
                $brands = $page->coming_brand;
            @endphp
            <section class="brand-wrapper">
                <div class="container">
                    <div class="home-hotel-heading" style="display: block;">
                        <div class="heading">
                            @if(isset($brands->heading) && !empty($brands->heading))
                                <h3 class="tt-uper fw-bold" style="font-size: 40px;">{{ $brands->heading }}</h3>
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
                                                <a href="{{ $brand->url ? $brand->url : 'javascript:void(0)'}}">
                                                    <div class="image">
                                                        {!! \App\Core\Helper\FrontendHelpers::renderImage($brand->banner) !!}
                                                    </div>
                                                    <p class="name fw-bold">{{ isset($brand->name) && !empty($brand->name) ? $brand->name : '' }}</p>
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

    <div class="modal fade" id="occupancyModal" tabindex="-1" role="dialog" aria-labelledby="occupancyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title tt-uper" style="color: #000;font-weight: bold;font-size: 16px" id="occupancyModalLabel">{{__('home_occupancy')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <div class="icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <select name="" id="adult-select" class="form-control occupancy-select">
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }} {{ $i > 1 ? __('adults_text') : __('adult_text') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="form-group">
                        <div class="icon">
                            <i class="fas fa-male"></i>
                        </div>
                        <select name="" id="child-select" class="form-control occupancy-select">
                            @for($i = 0; $i <= 5; $i++)
                                <option value="{{ $i }}">{{ $i }} {{ $i > 1 ? __('children_text') : __('child_text') }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="children-age-wrapper" style="display: none">
                        <div class="form-group" style="justify-content: flex-start;">
                            <div class="icon" style="width: 40px;"></div>
                            <div class="children-age-select">
                                <p class="tt-uper" style="color: #000; font-size: 10px">{{__('children_age_text')}}</p>
                                @for($j = 1; $j <= 5; $j++)
                                    <select name="" class="children-age">
                                        <option value="-1">-</option>
                                        @for($i = 0; $i <= 11; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                @endfor
                                <p class="error text-danger" style="margin-bottom: 0; font-size: 10px;display: none">{{__('children_age_error')}}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary btn-save">{{ __('save_button_text') }}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        const locations = JSON.parse('{!!  json_encode($mapData) !!}');
        const endPoints = JSON.parse('{!! json_encode(\App\Core\Glosary\EndpointConfig::getAll()) !!}')
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
                        @if($currentLanguage == 'ar')
                        $('#location').addClass('animate__slideInRight');
                        $('#location').removeClass('animate__slideOutRight');
                        @else
                        $('#location').addClass('animate__slideInLeft');
                        $('#location').removeClass('animate__slideOutLeft');
                        @endif
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
        $(document).ready(function (){
            var occupancies = [{
                adults : $('#adult-select').val(),
                children : $('#child-select').val(),
                ages : ""
            }];
            $('#occupancies').val(JSON.stringify(occupancies));
            $('.location-detail-wrapper .close').click(function (e) {
                e.preventDefault();
                @if($currentLanguage == 'ar')
                $(this).parents('.location-detail-wrapper').removeClass('animate__slideInRight');
                $(this).parents('.location-detail-wrapper').addClass('animate__slideOutRight');
                @else
                $(this).parents('.location-detail-wrapper').removeClass('animate__slideInLeft');
                $(this).parents('.location-detail-wrapper').addClass('animate__slideOutLeft');
                @endif
            })

            $('.btn-save').on('click',function (){
                let valid = true;
                let adult = $('#adult-select').val();
                let child = $('#child-select').val();
                let ages = '';
                $('.children-age-wrapper').find('.children-age').each(function (){
                    if ($(this).hasClass('show') && $(this).val() < 0) {
                        valid = false;
                    }
                })
                if (valid) {
                    $('#adults').text(adult);
                    $('#children').text(child);
                    $('.children-age-wrapper').find('.children-age').each(function (){
                        if ($(this).hasClass('show')) {
                            ages += $(this).val()+';';
                        }
                    })
                    occupancies[0].ages = ages.substr(0,ages.length - 1);
                    occupancies[0].children = child;
                    occupancies[0].adults = adult;

                    $('#occupancies').val(JSON.stringify(occupancies));
                    $(this).parents('.modal-content').find('.error').hide();
                    $('#occupancyModal').modal('hide');
                }else {
                    $(this).parents('.modal-content').find('.error').show();
                }

            })
            $('#child-select').on('change',function (){
                let val = $(this).val();
                $('.children-age-wrapper').find('.children-age').val(-1);
                if (val > 0) {
                    $('.children-age-wrapper').show();
                    $('.children-age-wrapper').find('.children-age').each(function (i){
                        if (i < parseInt(val)) {
                            $(this).addClass('show');
                        }else{
                            $(this).removeClass('show');
                        }
                    });
                }else{
                    $('.children-age-wrapper').hide();
                }
            })

            $('#hotel_code').on('change',function () {
                if ($(this).val() != -1) {
                    $('#bookingForm').find('.error').hide();
                }else{
                    $('#bookingForm').find('.error').show();
                }
            })

            $('.btn-check-available').on('click',function (e) {
                let valid = true;

                if(new Date($('#arrival').val()) > new Date($('#departure').val())) {
                    valid = false;
                    alert('{{__("date_error")}}');
                }
                if ($('#hotel_code').val() == -1 ){
                    valid = false;
                    $('#bookingForm').find('.error').show();
                }else{
                    $('#bookingForm').find('.error').hide();
                }
                if (!valid){
                    e.preventDefault();
                }
            })
        })
    </script>
@endsection
