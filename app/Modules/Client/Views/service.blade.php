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
                    @if($post->post_content != '')
                        <div class="hotels-description">
                            {{ $post->post_content  }}
                        </div>
                    @endif
                </div>
                @if(isset($pageMetaMap[\App\Core\Glosary\MetaKey::COMPLETE_ITEM['NAME']]) && !empty($pageMetaMap[\App\Core\Glosary\MetaKey::COMPLETE_ITEM['NAME']]))
                    @php
                        $items = $pageMetaMap[\App\Core\Glosary\MetaKey::COMPLETE_ITEM['NAME']];
                    @endphp
                    <div class="services-content">
                        <div class="row">
                            @foreach($items as $item)
                            <div class="col-xl-3 col-lg-4 col-sm-6">
                                <div class="service-item">
                                    <div class="image">
                                        {!! \App\Core\Helper\FrontendHelpers::renderImage($item->image) !!}
                                    </div>
                                    <div class="content">
                                        <a href="#" title="title">
                                            <div class="title">
                                                <h3>{{ $item->desc }}</h3>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection
