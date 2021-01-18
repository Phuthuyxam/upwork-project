@php
    $footerData  = OptionHelpers::getOptionByKey(\App\Core\Glosary\OptionMetaKey::FOOTER['VALUE']);
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
                    <span class="email">{{ isset($systemConfig['email']) && !empty($systemConfig['email']) ? $systemConfig['email'] : "" }}</span>
                    <span class="seperate"></span>
                    <span class="phone">{{ isset($systemConfig['phone']) && !empty($systemConfig['phone']) ? $systemConfig['phone'] : "" }}</span>
                    <span class="seperate"></span>
                    <span class="address">{{ isset($systemConfig['address']) && !empty($systemConfig['address']) ? $systemConfig['address'] : "" }}</span>
                </div>
                <div class="footer-social">
                    <a href="{{ isset($systemConfig['social_link'][0]) && !empty($systemConfig['social_link'][0]) ? $systemConfig['social_link'][0] : "#" }}"><i class="fab fa-facebook-f aria-hidden="true"></i></a>
                    <a href="{{ isset($systemConfig['social_link'][1]) && !empty($systemConfig['social_link'][1]) ? $systemConfig['social_link'][1] : "#" }}"><i class="fab fa-twitter" aria-hidden="true"></i></a>
                    <a href="{{ isset($systemConfig['social_link'][2]) && !empty($systemConfig['social_link'][2]) ? $systemConfig['social_link'][2] : "#" }}"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                    <a href="{{ isset($systemConfig['social_link'][3]) && !empty($systemConfig['social_link'][3]) ? $systemConfig['social_link'][3] : "#" }}"><i class="fab fa-youtube" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="footer-copyright">
                <p>{{ ( isset($footerData['copyright_text']) && !empty(isset($footerData['copyright_text'])) ) ? $footerData['copyright_text'] : "Copyright © 2021 Fronter.All Rights Reserved" }}</p>
                <p>{{ ( isset($footerData['develop_text']) && !empty(isset($footerData['develop_text'])) ) ? $footerData['develop_text'] : "Developed by : Brackets Technology" }}</p>
            </div>
        </div>
    </div>
</footer>