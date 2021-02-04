@php
    $currentLanguage = isset($currentLanguage) ? $currentLanguage : false;
    $footerData  = OptionHelpers::getOptionByKey(\App\Core\Glosary\OptionMetaKey::FOOTER['VALUE'] , $currentLanguage );
    if(isset($footerData) && json_decode($footerData, true))
        $footerData = json_decode($footerData,true);
@endphp
<footer>
    <div class="footer-wrapper">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">
                    <a href="{{ URL::to('/') }}">
                        @if(isset($systemConfig['logo']) && !empty($systemConfig['logo']))
                            {!! FrontendHelpers::renderImage($systemConfig['logo']) !!}
                        @endif
                    </a>
                </div>
                <div class="footer-contact">
                    @if(isset($systemConfig['email']) && !empty($systemConfig['email']))
                        <span class="email">{{ $systemConfig['email'] }}</span>
                    @endif
                    @if(isset($systemConfig['phone']) && !empty($systemConfig['phone']))
                        <span class="phone">{{ $systemConfig['phone'] }}</span>
                    @endif
                    @if(isset($systemConfig['address']) && !empty($systemConfig['address']))
                        <span class="address">{{ $systemConfig['address']}}</span>
                    @endif
                </div>
                <div class="footer-social">
                    <a href="{{ isset($systemConfig['social_link'][0]) && !empty($systemConfig['social_link'][0]) ? $systemConfig['social_link'][0] : "#" }}" target="_blank"><i class="fab fa-facebook-f aria-hidden="true"></i></a>
                    <a href="{{ isset($systemConfig['social_link'][1]) && !empty($systemConfig['social_link'][1]) ? $systemConfig['social_link'][1] : "#" }}" target="_blank"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                    <a href="{{ isset($systemConfig['social_link'][2]) && !empty($systemConfig['social_link'][2]) ? $systemConfig['social_link'][2] : "#" }}" target="_blank"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                    <a href="{{ isset($systemConfig['social_link'][3]) && !empty($systemConfig['social_link'][3]) ? $systemConfig['social_link'][3] : "#" }}" target="_blank"><i class="fab fa-youtube" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="footer-copyright">
                <div><p>{{ ( isset($footerData['copyright_text']) && !empty(isset($footerData['copyright_text'])) ) ? $footerData['copyright_text'] : "Copyright © 2021 Fronter.All Rights Reserved" }}</p></div>
                <div>{!! ( isset($footerData['develop_text']) && !empty(isset($footerData['develop_text'])) ) ? $footerData['develop_text'] : "Developed by : Brackets Technology"  !!}</div>
            </div>
        </div>
    </div>
</footer>
