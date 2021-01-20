<header>
    <div class="header-wrapper">
        <div class="container">
            <div class="header-content">
                <div class="menu-mobile">
                    <i class="fa fa-bars" aria-hidden="true"></i>
                </div>
                <div class="header-logo">
                    <a href="{{ URL::to('/') }}">
                        @if(isset($systemConfig['logo']) && !empty($systemConfig['logo']))
                        {!! FrontendHelpers::renderImage($systemConfig['logo']) !!}
                        @endif
                    </a>
                </div>
                <div class="menu-site">
                    <div class="header-menu">
                        <ul class="main-menu">
                            @if(isset($menus) && !empty($menus))
                                @foreach($menus as $menu)
                                    <li class="menu-item {{ (url()->current() == $menu['url'] && $menu['url'] != null) ? "active" : false }}">
                                        <a class="tt-uper" href="{{ $menu['url'] }}">{{ $menu['title'] }}</a>
                                    </li>
                                @endforeach
                            @endif

                        </ul>

                    </div>
                    <div class="overlay">
                        <button class="btn btn-close">x</button>
                    </div>
                </div>

                @php
                    $languages = \App\Core\Glosary\LocationConfigs::getAll();
                    $currentLan = app()->getLocale();
                    $modeTranslation = ( isset($translationMode) && !empty($translationMode) ) ? $translationMode : false;
                @endphp

                <div class="header-languages">
                    <div class="language-select-wrapper">
                        <i style="font-size: 20px;" class="fas fa-globe"></i>
                        <div class="language-select">
                            <span class="language">{{ __("header_label_language") }}</span>
                            <i class="fa fa-angle-down"></i>
                        </div>

                        @if(isset($languages) && !empty($languages))
                            <div class="language-options">
                                <ul>
                                    @foreach($languages as $lan)
                                        <li>
                                            <a href="{{ renderTranslationUrl(url()->current() , $lan['VALUE'], $modeTranslation) }}">{{ strtoupper($lan['VALUE']) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</header>
