<?php

use App\Core\Glosary\LocationConfigs;

if (!function_exists('getClientIp')) {
    function getClientIp()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if (getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if (getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if (getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if (getenv('HTTP_FORWARDED'))
            $ipaddress = getenv('HTTP_FORWARDED');
        else if (getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}
if (!function_exists('displayAlert')) {
    function displayAlert($messageFull)
    {
        if (!$messageFull) return '';
        list($type, $message) = explode('|', $messageFull);
        return sprintf('<div class="alert alert-%s" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>%s</div>', $type, $message);
    }
}

if(!function_exists('generatePrefixLanguage')) {
    function generatePrefixLanguage() {
        if(!isset($_SERVER['REQUEST_URI']) || empty($_SERVER['REQUEST_URI'])) return false;
        $serverPath = explode('/', $_SERVER['REQUEST_URI']);
        $firstLevel = $serverPath[1];
        if((LocationConfigs::checkLanguageCode($firstLevel))){
            app()->setLocale($firstLevel);
            return  app()->getLocale().'/';
        }else {
            return '';
        }
    }
}

if(!function_exists('renderTranslationUrl')) {
    function renderTranslationUrl($url, $langCode) {
        if(empty(parse_url($url))) return false;
        $urlParse = parse_url($url);
        if(!isset($urlParse['path']) || empty($urlParse['path']))  return  $urlParse['scheme'] . "://" . $urlParse['host'] . ((isset($urlParse['port']) && !empty($urlParse['port']) ) ? ":" . $urlParse['port'] : "" ) . "/" . $langCode;
        $serverPath = explode('/', $urlParse['path']);
        $firstLevel = $serverPath[1];
        if((LocationConfigs::checkLanguageCode($firstLevel))){
            $serverPath[1] = $langCode;
            $newPath = implode("/", $serverPath);
            return  $urlParse['scheme'] . "://" . $urlParse['host'] . ((isset($urlParse['port']) && !empty($urlParse['port']) ) ? ":" . $urlParse['port'] : "" ) . $newPath;
        }else {
            $urlParse['path'] = "/" . $langCode . $urlParse['path'];
            return $urlParse['scheme'] . "://" . $urlParse['host'] . ((isset($urlParse['port']) && !empty($urlParse['port']) ) ? ":" . $urlParse['port'] : "" ) . $urlParse['path'];
        }
    }
}

if(!function_exists('generateSeoOption')) {
    function generateSeoOption() {

    }
}

if(!function_exists('getDataSeoOption')) {
    function getDataSeoOption($objectId, $seoType, $defaultData = []) {
        $seoRepository = \App\Modules\Seo\Repositories\SeoRepository::class;
        $seoConfig = \App\Core\Glosary\SeoConfigs::getSeoKey();
        $seoRepository = app()->make(
            $seoRepository );
        $seoDatas = $seoRepository->filter([ ['object_id' , $objectId] , ['seo_type', $seoType]]);
        $resultData = [];
        if($seoDatas->isNotEmpty()) {
            foreach ($seoDatas as $seo) {
                $resultData[$seo->seo_key] = $seo->seo_value;
            }
        }

        $localBusiness = \Spatie\SchemaOrg\Schema::advertiserContentArticle()->name('blog name');
        $localBusiness->description($resultData[$seoConfig['SEO']['DESC']]);
        $localBusiness->knowsLanguage(app()->getLocale());
        $localBusiness->url(url()->current());
        $localBusiness->sameAs(['https://www.facebook.com/']);
        $localBusiness->logo('logo');
        $localBusiness->telephone('0344719081');

        ob_start();
        ?>
        <title>
            <?php echo ( isset($resultData[$seoConfig['SEO']['TITLE']]) && !empty($resultData[$seoConfig['SEO']['TITLE']]) ) ? $resultData[$seoConfig['SEO']['TITLE']] :
                ( isset($defaultData[$seoConfig['SEO']['TITLE']]) ? $defaultData[$seoConfig['SEO']['TITLE']] : "" ) ?>
        </title>
        <meta name="description"
              content="<?php echo ( isset($resultData[$seoConfig['SEO']['DESC']]) && !empty($resultData[$seoConfig['SEO']['DESC']]) ) ? $resultData[$seoConfig['SEO']['DESC']] :
                  (isset($defaultData[$seoConfig['SEO']['DESC']]) ? $defaultData[$seoConfig['SEO']['DESC']] : "") ?>"/>
        <meta name="robots" content="index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1, noarchive"/>
        <meta name="robots" content="index, follow, max-video-preview:-1, noimageindex, noarchive, nosnippet"/>
        <link rel="canonical"
              href="<?php echo ( isset($resultData[$seoConfig['SEO']['CANONICAL_URL']]) && !empty($resultData[$seoConfig['SEO']['CANONICAL_URL']]) ) ? $resultData[$seoConfig['SEO']['CANONICAL_URL']] :
                  (isset($defaultData[$seoConfig['SEO']['CANONICAL_URL']]) ? $defaultData[$seoConfig['SEO']['CANONICAL_URL']] : "")?>"/>
        <meta property="og:locale" content="en_US"/>
        <meta property="og:type" content="article"/>
        <meta property="og:title"
              content="<?php echo ( isset($resultData[$seoConfig['SOCIAL']['FACEBOOK']['TITLE']]) && !empty($resultData[$seoConfig['SOCIAL']['FACEBOOK']['TITLE']]) ) ? $resultData[$seoConfig['SOCIAL']['FACEBOOK']['TITLE']] :
                  (isset($defaultData[$seoConfig['SOCIAL']['FACEBOOK']['TITLE']]) ? $defaultData[$seoConfig['SOCIAL']['FACEBOOK']['TITLE']] : "") ?>"/>
        <meta property="og:description"
              content="<?php echo ( isset($resultData[$seoConfig['SOCIAL']['FACEBOOK']['DESCRIPTION']]) && !empty($resultData[$seoConfig['SOCIAL']['FACEBOOK']['DESCRIPTION']]) ) ? $resultData[$seoConfig['SOCIAL']['FACEBOOK']['DESCRIPTION']] :
                  (isset($defaultData[$seoConfig['SOCIAL']['FACEBOOK']['DESCRIPTION']]) ? $defaultData[$seoConfig['SOCIAL']['FACEBOOK']['DESCRIPTION']] : "" ) ?>"/>
        <meta property="og:url" content="http://localhost/decor/day-la-bai-viet-moi-seo-slug/"/>
        <meta property="og:site_name" content="Tshirt-shop"/>
        <meta property="article:published_time" content="<?php echo isset($defaultData['published_time']) ? $defaultData['published_time'] : ""  ?>"/>
        <meta property="article:modified_time" content="<?php echo isset($defaultData['modified_time']) ? $defaultData['modified_time'] : ""  ?>"/>
        <meta property="og:image"
              content="<?php echo ( isset($resultData[$seoConfig['SOCIAL']['FACEBOOK']['IMAGE']]) && !empty($resultData[$seoConfig['SOCIAL']['FACEBOOK']['IMAGE']]) ) ? $resultData[$seoConfig['SOCIAL']['FACEBOOK']['IMAGE']] :
                  ( isset($defaultData[$seoConfig['SOCIAL']['FACEBOOK']['IMAGE']]) ? $defaultData[$seoConfig['SOCIAL']['FACEBOOK']['IMAGE']] : "" ) ?>"/>
        <meta property="og:image:width" content="800"/>
        <meta property="og:image:height" content="799"/>
        <meta name="twitter:card" content="summary_large_image"/>
        <meta name="twitter:title"
              content="<?php echo ( isset($resultData[$seoConfig['SOCIAL']['TWITTER']['TITLE']]) && !empty($resultData[$seoConfig['SOCIAL']['TWITTER']['TITLE']]) ) ? $resultData[$seoConfig['SOCIAL']['TWITTER']['TITLE']] :
                  (isset($defaultData[$seoConfig['SOCIAL']['TWITTER']['TITLE']]) ? $defaultData[$seoConfig['SOCIAL']['TWITTER']['TITLE']]  : "" ) ?>"/>
        <meta name="twitter:description"
              content="<?php echo ( isset($resultData[$seoConfig['SOCIAL']['TWITTER']['DESCRIPTION']]) && !empty($resultData[$seoConfig['SOCIAL']['TWITTER']['DESCRIPTION']]) ) ? $resultData[$seoConfig['SOCIAL']['TWITTER']['DESCRIPTION']] :
                  (isset($defaultData[$seoConfig['SOCIAL']['TWITTER']['DESCRIPTION']]) ? $defaultData[$seoConfig['SOCIAL']['TWITTER']['DESCRIPTION']] : "") ?>"/>
        <meta name="twitter:image"
              content="<?php echo ( isset($resultData[$seoConfig['SOCIAL']['TWITTER']['IMAGE']]) && !empty($resultData[$seoConfig['SOCIAL']['TWITTER']['IMAGE']]) ) ? $resultData[$seoConfig['SOCIAL']['TWITTER']['IMAGE']] :
                  ( isset($defaultData[$seoConfig['SOCIAL']['TWITTER']['IMAGE']]) ? $defaultData[$seoConfig['SOCIAL']['TWITTER']['IMAGE']] : "" ) ?>"/>
        <meta name="twitter:label1" content="Written by">
        <meta name="twitter:data1" content="admin">
        <meta name="twitter:label2" content="Est. reading time">
        <meta name="twitter:data2" content="0 minutes">

        <?php echo $localBusiness->toScript() ?>

        <?php
        $content = ob_get_contents();
        ob_get_clean();
        return $content;
    }
}

if(!function_exists('renderMediaManage')) {
    function renderMediaManage($inputName , $previewImage = null ) {
        ob_start();
        ?>
        <div class="form-group media-load-image">
            <div class="preview-image" style="width: 100%">
                <div class="close" onclick="deleteImagePreview(this)">
                    <i class="dripicons-cross"></i>
                </div>
                <div class="image-preview-container">
                    <?php if(isset($previewImage) && !empty($previewImage)): ?>
                    <img class="image-preview" style="width: 100%" src="<?php echo $previewImage ?>" alt="your image">
                    <?php endif; ?>
                </div>
            </div>
            <div class="input-group">
                <input type="text" style="padding: 3px 5px; overflow: hidden" name="<?php echo $inputName ?>" class="form-control required home-slider-image" aria-describedby="button-image" readonly
                       value="<?php echo (isset($previewImage) && !empty($previewImage)) ? $previewImage : "" ?>">
                <div class="input-group-append">
                    <button class="btn btn-primary waves-effect waves-light btn-popup-media" type="button" onclick="openMediaManager(this)">Select Image</button>
                </div>
            </div>
        </div>
        <?php
        $content = ob_get_contents();
        ob_get_clean();
        return $content;
    }
}

