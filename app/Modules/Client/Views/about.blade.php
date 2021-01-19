@extends('Client::layouts.master')
@section('html')
    @if($currentLanguage == 'en')
    <html lang="en">
    @else
        <html lang="ar" dir="rtl">
    @endif
@endsection

@section('seo')
    {!! getDataSeoOption($post->id, \App\Core\Glosary\SeoConfigs::SEOTYPE['SINGLE']['KEY'], $seoDefault) !!}
@endsection
@section('style')
    @if($currentLanguage == 'ar')
        <link rel="stylesheet" href="{{ asset('client/css/arab.css') }}">
    @endif
@endsection

    @section('content')
    <div class="content-wrapper">
        <section class="banner-wrapper">
            <div class="banner-image">
                @if(isset($pageMetaMap[\App\Core\Glosary\MetaKey::BANNER['NAME']]) && !empty($pageMetaMap[App\Core\Glosary\MetaKey::BANNER['NAME']]))
                    <picture>
                        <source srcset="{{ $pageMetaMap['banner'][2] }}" media="(max-width: 415px)">
                        <source srcset="{{ $pageMetaMap['banner'][1] }}" media="(max-width: 768px)">
                        {!! \App\Core\Helper\FrontendHelpers::renderImage($pageMetaMap['banner'][0]) !!}
                    </picture>
                @endif
            </div>
            <div class="banner-content">
                <div class="banner-title">
                    <h1>{{ $post->post_title }}</h1>
                </div>
                <div class="breadscrum">
                    <ul>
                        <li class="item"><a href="{{ route('index') }}">{{__('home_title')}}</a></li>
                        <li class="item active"><span>
                            <div class="rectangle"></div> {{ $post->post_title }}
                        </span></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="hotels-wrapper">
            <div class="container">
                <div class="hotels-heading">
                    <div class="hotels-title">
                        <h2 class="fw-bold">{{ $post->post_excerpt }}</h2>
                    </div>
                    <div class="hotels-description">
                        {!! $post->post_content !!}
                    </div>
                </div>
                <div class="services-content">
                    @if(isset($itemMap) && !empty($itemMap))
                        <div class="about-section">
                            <div class="about-heading">
                                <div class="diamond">
                                    <i class="fal fa-eye"></i>
                                </div>
                                <h2 class="fw-bold">{{ $currentLanguage == 'en' ? 'Our Vision' : 'رؤيتنا' }}</h2>
                            </div>
                            <div class="row">
                                @foreach($itemMap[0] as $item)
                                    <div class="col-xl-4 col-lg-4 col-sm-6">
                                        <div class="about-item">
                                            <div class="image">
                                               {!! \App\Core\Helper\FrontendHelpers::renderImage($item->image) !!}
                                            </div>
                                            <div class="content">
                                                <a href="#" title="title">
                                                    <div class="title">
                                                        <p>{{ $item->desc }}</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="about-section">
                            <div class="about-heading">
                                <div class="diamond">
                                    <i class="fal fa-bullseye-arrow"></i>
                                </div>
                                <h2 class="fw-bold">{{ $currentLanguage == 'en' ? 'Our Missions' : 'مهمتنا' }}</h2>
                            </div>
                            <div class="row">
                                @foreach($itemMap[1] as $item)
                                    <div class="col-xl-4 col-lg-4 col-sm-6">
                                        <div class="about-item">
                                            <div class="image">
                                                {!! \App\Core\Helper\FrontendHelpers::renderImage($item->image) !!}
                                            </div>
                                            <div class="content">
                                                <a href="#" title="title">
                                                    <div class="title">
                                                        <p>{{ $item->desc }}</p>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if(isset($imageMap) && !empty($imageMap))
                         <div class="about-section">
                            <div class="about-heading">
                                <div class="diamond">
                                    <i class="fal fa-award"></i>
                                </div>
                                <h2 class="fw-bold"> {{ $currentLanguage == 'en' ? 'Our Awards' : 'جوائزنا' }}</h2>
                            </div>
                             @foreach($imageMap as $value)
                                <div class="row">
                                    @php
                                        $col = 12 / count($value);
                                    @endphp
                                    @foreach($value as $image)
                                        <div class="col-xl-{{$col}} col-lg-{{$col}} col-sm-6">
                                            <div class="award-item">
                                                <div class="image">
                                                    <a href="{{ $image }}" data-fancybox="gallery" data-width="1000" data-caption="award1">
                                                        {!! \App\Core\Helper\FrontendHelpers::renderImage($image) !!}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                             @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>
@endsection
