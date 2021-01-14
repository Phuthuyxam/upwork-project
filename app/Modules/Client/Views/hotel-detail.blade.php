@extends('Client::layouts.master')
@section('content')
    <div class="content-wrapper">
        <section class="banner-wrapper">
            <div class="banner-image">
                @if(isset($postMetaMap[\App\Core\Glosary\MetaKey::BANNER['NAME']]) && !empty($postMetaMap[App\Core\Glosary\MetaKey::BANNER['NAME']]))
                <picture>
                    <source srcset="{{ $postMetaMap['banner'][2] }}" media="(max-width: 415px)">
                    <source srcset="{{ $postMetaMap['banner'][1] }}" media="(max-width: 768px)">
                    <img src="{{ $postMetaMap['banner'][0] }}" alt="hotel-banner">
                </picture>
                @endif
            </div>
            <div class="banner-content">
                <div class="banner-title">
                    <img src="{{ $termMetaMap[\App\Core\Glosary\MetaKey::BRAND_LOGO['NAME']] }}" alt="">
                </div>
                <div class="breadscrum">
                    <ul>
                        <li class="item"><a href="{{ route('index') }}">Home</a></li>
                        <li class="item active"><span>
                            <div class="rectangle"></div> Our Hotels
                        </span></li>
                        <li class="item active"><span>
                            <div class="rectangle"></div> Frontel Al Harithia Hotel
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
                                                <img src="images/Group3832.svg" alt="">
                                            </div>
                                            <img src="{{ $value }}" class="thumb" alt="detail-hotel"
                                                 title="detail-hotel">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            <div class="slider-nav-wrapper">
                                <div class="blur-side">
                                    <div class="left">
                                        <img src="images/Rectangle901-Copy.png" alt="">
                                    </div>
                                    <div class="right">
                                        <img src="images/Rectangle901.png" alt="">
                                    </div>
                                </div>
                                <div class="slider-nav">
                                    @if(isset($postMetaMap[App\Core\Glosary\MetaKey::SLIDE['NAME']]) && !empty($postMetaMap[App\Core\Glosary\MetaKey::SLIDE['NAME']]))
                                        @php
                                            $slides = $postMetaMap[\App\Core\Glosary\MetaKey::SLIDE['NAME']];
                                        @endphp
                                        @foreach($slides as $value)
                                            <div class="item">
                                                <img src="{{ $value }}" class="thumb" alt="detail-hotel"
                                                     title="detail-hotel">
                                                <div class="overlay"></div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="detail-content">
                            <div class="description-heading">
                                <h3 class="tt-uper fw-semiBold">DESCRIPTION</h3>
                            </div>
                            <div class="description">
                                {!! $post->post_content !!}
                            </div>
                            <div class="room-type">
                                <div class="heading">
                                    <h2 class="fw-semiBold">Rooms Type & Inventory</h2>
                                </div>
                                <div class="content">
                                    <div class="row">
                                        <div class="col-xl-6 col-lg-6 col-sm-6">
                                            @if(isset($postMetaMap[\App\Core\Glosary\MetaKey::ROOM_TYPE['NAME']]) && !empty($postMetaMap[\App\Core\Glosary\MetaKey::ROOM_TYPE['NAME']]))
                                                <div class="type-table">
                                                        @php
                                                            $types = $postMetaMap[\App\Core\Glosary\MetaKey::ROOM_TYPE['NAME']];
                                                        @endphp
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <th>Rooms Type</th>
                                                            <th style="text-align: center;">Inventory</th>
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
                                            @endif
                                        </div>
                                        <div class="col-xl-6 col-lg-6 col-sm-6">
                                            @if(isset($postMetaMap[\App\Core\Glosary\MetaKey::FACILITY['NAME']]) && !empty($postMetaMap[\App\Core\Glosary\MetaKey::FACILITY['NAME']]))
                                                @php
                                                    $facilities = $postMetaMap[\App\Core\Glosary\MetaKey::FACILITY['NAME']];
                                                @endphp
                                                <div class="facilities">
                                                    <h2 class="fw-semiBold">Hotel Facilities and Amenities</h2>
                                                    <div class="facility-list">
                                                        <ul>
                                                            @foreach($facilities as $value)
                                                                <li>
                                                                    <div class="icon">
                                                                        <img src="images/Group3811.svg" alt="">
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
                            <div class="map">
                                <iframe src="https://maps.google.com/maps?q={{ $map->location->lat }}, {{ $map->location->long }}&z=15&output=embed"
                                        width="100%" height="400" frameborder="0" style="border:0"></iframe>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-xl-3">
                        <div class="reservation-form" style="background-image: url(images/MaskGroup31.jpg);">
                            <h4 class="fw-bold">Your Reservation</h4>
                            <form action="">
                                <div class="date-input">
                                    <div class="icon-calendar">
                                        <img src="images/Icon feathercalendar.svg" alt="">
                                    </div>
                                    <input type="text" name="" class="form-control detail-date-picker" value=""
                                           placeholder="Check-In" required="required" title="">
                                </div>
                                <div class="date-input">
                                    <div class="icon-calendar">
                                        <img src="images/Icon feathercalendar.svg" alt="">
                                    </div>
                                    <input type="text" name="" class="form-control detail-date-picker" value=""
                                           placeholder="Check-Out" required="required" title="">
                                </div>
                                <select class="form-control" name="">
                                    <option value="default">Adults</option>
                                    <option value="1">1</option>
                                    <option value="1">2</option>
                                    <option value="1">3</option>
                                    <option value="1">4</option>
                                </select>
                                <select class="form-control" name="">
                                    <option value="default">Childrens</option>
                                    <option value="1">1</option>
                                    <option value="1">2</option>
                                    <option value="1">3</option>
                                    <option value="1">4</option>
                                </select>
                                <div class="submit-wrapper">
                                    <input type="submit" class="btn btn-submit" value="CHECK AVAILIBILITY">
                                </div>
                            </form>
                        </div>
                    </div>
                    @if(isset($relatePostMap) && !empty($relatePostMap) && isset($relatePostMetaMap) && !empty($relatePostMetaMap))
                    <div class="col-xl-9">
                        <div class="other-hotels">
                            <div class="heading">
                                <h2 class="fw-semiBold">Other Hotels</h2>
                            </div>
                            <div class="hotels-content">
                                <div class="row">
                                    @foreach($relatePostMap as $key => $value)
                                    <div class="col-xl-4 col-lg-4 col-sm-6">
                                        <div class="hotel-item">
                                            <div class="image">
                                                <img src="{{ $relatePostMetaMap[$key] }}" alt="hotel1" title="hotel1">
                                                <div class="view-more-overlay">
                                                    <a href="#" class="tt-uper" title="title">more info</a>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <a href="#" title="title">
                                                    <div class="rate">
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                        <i class="fas fa-star" aria-hidden="true"></i>
                                                    </div>
                                                    <div class="title">
                                                        <h3>The Venue Corniche</h3>
                                                        <p class="city">Jeddah</p>
                                                        <p class="price">from SAR 850.00 / night</p>
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
