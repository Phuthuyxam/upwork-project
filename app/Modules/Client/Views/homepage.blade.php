@extends('Client::layouts.master')
{{--@section('seo')--}}
{{--    {!! getDataSeoOption(-99, 'homepage', $seoDefault) !!}--}}
{{--@endsection--}}
@section('content')
    <div class="content-wrapper">
        <section class="home-slider-wrapper">
            @if( isset($page->slider) && !empty($page->slider))
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
            <div class="hotel-search-wrapper">
                <form action="">
                    <div class="hotel-search-content">
                        <div class="hotel-selection search-item">
                            <p class="title tt-uper fw-bold">FIND YOUR HOTEL</p>
                            <div class="hotel-select">
                                <div class="select-arrow">
                                    <img src="{{ asset('client/images/Path6702.png') }}" alt="">
                                </div>
                                <select class="form-control" required="required">
                                    <option value="default">Select Your Hotel</option>
                                    <option value="">The Venue</option>
                                    <option value="">Frontel</option>
                                    <option value="">Three points hotel</option>
                                </select>
                            </div>
                        </div>
                        <div class="check-in-out-date search-item">
                            <div class="check-in">
                                <p class="title tt-uper fw-bold">check in</p>
                                <p class="date fw-semiBold">20</p>
                                <p class="title month-year tt-uper fw-semiBold">dec 2020</p>
                                <input type="text" class="date-picker start-date form-control" name="start-date" readonly>
                            </div>
                            <div class="angle-left">
                                <img src="{{ asset('client/images/Path6701.png') }}" alt="Path6701">
                            </div>
                            <div class="check-out">
                                <p class="title tt-uper fw-bold">check out</p>
                                <p class="date fw-semiBold">22</p>
                                <p class="title month-year tt-uper fw-semiBold">dec 2020</p>
                                <input type="text" class="date-picker end-date form-control" name="end-date" readonly>
                            </div>
                        </div>
                        <div class="occupancy search-item">
                            <p class="title tt-uper fw-bold">occupancy</p>
                            <div class="occupancy-detail">
                                <div class="adult-select">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <select class="form-control" name="adult" id="">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3" selected>3</option>
                                        <option value="4">4</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                                <div class="children-select">
                                    <i class="fa fa-male" aria-hidden="true"></i>
                                    <select class="form-control" name="adult" id="">
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
                            <p class="title fw-bold">Promotional code</p>
                            <input type="text" class="form-control">
                        </div>
                        <div class="btn-submit-wrapper">
                            <input type="submit" class="btn btn-check-available tt-uper fw-bold" value="Check availability">
                        </div>
                    </div>
                </form>
            </div>
        </section>
        @if(isset($page->our_service) && !empty($page->our_service))
            <section class="home-service-wrapper">
                <div class="home-service-background">
                    {!! \App\Core\Helper\FrontendHelpers::renderImage($page->our_service->background) !!}
                </div>
                <div class="container">
                    <div class="home-service-content">
                        <div class="home-service-intro" style="background-image: url({{ asset('client/images/MaskGroup14.jpg') }});">
                            <div class="home-service">
                                <h2 class="tt-uper fw-bold">{{ $page->our_service->title }}</h2>
                                <h3 class="fw-semiBold">{{ $page->our_service->heading }}</h3>
                                {!! $page->our_service->paragraph !!}
                                <a href="{{ $page->our_service->url }}" class="btn-view-more" title="title">
                                    <div class="diamond">
                                        <i class="fas fa-long-arrow-alt-right"></i>
                                    </div>
                                    <span class="tt-uper">see more services</span>
                                </a>
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
                        <h3 class="tt-uper">{{ $page->our_hotel->title }}</h3>
                        <h2 class="tt-uper fw-bold">{{ $page->our_hotel->heading }}</h2>
                    </div>
                    <div class="view-more-detail">
                        <a href="{{ $page->our_hotel->url }}" class="btn-view-more" title="title">
                            <div class="diamond">
                                <i class="fas fa-long-arrow-alt-right" aria-hidden="true"></i>
                            </div>
                            <span class="tt-uper">see more details</span>
                        </a>
                    </div>
                </div>
                @if(isset($page->our_hotel->hotels) && !empty($page->our_hotel->hotels))
                    <div class="home-hotel-content">
                        <div class="row">
                            @foreach($page->our_hotel->hotels as $item)
                                <div class="col-xl-3 col-lg-3 col-sm-6">
                                <a href="#" title="title">
                                    <div class="home-hotel-item">
                                        <div class="image">
                                            {!! \App\Core\Helper\FrontendHelpers::renderImage($item->banner) !!}
                                        </div>
                                        <div class="overlay">
                                            <div class="logo">
                                                {!! \App\Core\Helper\FrontendHelpers::renderImage($item->logo) !!}
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
        <section class="brand-wrapper">
            <div class="container">
                <div class="home-hotel-heading" style="display: block;">
                    <div class="heading">
                        <h3 class="tt-uper">more yet to come</h3>
                        <h2 class="tt-uper fw-bold">our brands</h2>
                    </div>
                </div>
                <div class="brand-content">
                    <div class="brand-slider">
                        <div class="item"><img src="images/FRONTEL WWL.png" alt=""></div>
                        <div class="item"><img src="images/makanlogo.png" alt=""></div>
                        <div class="item"><img src="images/LL.png" alt=""></div>
                        <div class="item"><img src="images/MaskGroup1.png" alt=""></div>
                        <div class="item"><img src="images/Venue.png" alt=""></div>
                        <div class="item"><img src="images/FRONTEL WWL.png" alt=""></div>
                        <div class="item"><img src="images/makanlogo.png" alt=""></div>
                        <div class="item"><img src="images/LL.png" alt=""></div>
                        <div class="item"><img src="images/MaskGroup1.png" alt=""></div>
                        <div class="item"><img src="images/Venue.png" alt=""></div>
                    </div>
                </div>
            </div>
        </section>
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
