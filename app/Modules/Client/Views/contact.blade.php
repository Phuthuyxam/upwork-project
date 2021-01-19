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
                            {!! $post->post_content !!}
                        </div>
                    @endif
                </div>
                <div class="hotels-content">
                    <div class="row">
                        <div class="col-xl-7 col-lg-7">
                            <div class="contact-form">
                                <form action="{{ route('contact_form') }}" method="POST">
                                    @csrf
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-sm-6">
                                                <input type="text" class="form-control" name="contact_name" id=""
                                                       placeholder="{{__('contact_form_placeholder_name')}}">
                                                <span class="text-danger">{{ $errors->first('contact_name') }}</span>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-sm-6">
                                                <input type="text" class="form-control" name="contact_email" id=""
                                                       placeholder="{{__('contact_form_placeholder_email')}}">
                                                <span class="text-danger">{{ $errors->first('contact_email') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="col-xl-6 col-lg-6 col-sm-6">
                                                <input type="text" class="form-control" name="contact_phone" id=""
                                                       placeholder="{{__('contact_form_placeholder_phone')}}">
                                                <span class="text-danger">{{ $errors->first('contact_phone') }}</span>
                                            </div>
                                            <div class="col-xl-6 col-lg-6 col-sm-6">
                                                <input type="text" class="form-control" name="contact_project" id=""
                                                       placeholder="{{__('contact_form_placeholder_project')}}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    <textarea class="form-control" name="contact_message" id=""
                                              style="width: 100%;height: 160px;resize:none" placeholder="{{__('contact_form_placeholder_message')}}"></textarea>
                                    </div>
                                    <div class="submit-wrapper">
                                        <input type="submit" class="btn btn-submit" value="{{ __('contact_form_label_submit') }}">
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="col-xl-5 col-lg-5">
                            <div class="contact-list">
                                <div class="row">
                                    <div class="col-xl-6 col-lg-6 col-sm-6 col-6">
                                        <div class="item">
                                            <div class="icon">
                                                <div class="diamond">
                                                    <i class="far fa-envelope"></i>
                                                </div>
                                            </div>
                                            @php
                                                $systemConfig = OptionHelpers::getSystemConfigByKey('general');
                                                if($systemConfig && json_decode($systemConfig,true))
                                                $systemConfig = json_decode($systemConfig, true);
                                            @endphp
                                            <div class="content">
                                                <p class="title fw-medium">{{__('contact_form_label_email')}} :</p>
                                                <a href="mailto:{{ isset($systemConfig['email']) ? $systemConfig['email'] : ""  }}">{{ isset($systemConfig['email']) ? $systemConfig['email'] : ""  }}</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6 col-lg-6 col-sm-6 col-6">
                                        <div class="item">
                                            <div class="icon">
                                                <div class="diamond">
                                                    <i class="fas fa-phone-alt"></i>
                                                </div>
                                            </div>
                                            <div class="content">
                                                <p class="title fw-medium">{{__('contact_form_label_phone')}} :</p>
                                                <a href="tel:{{ isset($systemConfig['phone']) ? $systemConfig['phone'] : ""  }}">{{ isset($systemConfig['phone']) ? $systemConfig['phone'] : ""  }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
