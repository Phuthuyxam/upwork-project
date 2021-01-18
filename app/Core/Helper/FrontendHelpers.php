<?php


namespace App\Core\Helper;


class FrontendHelpers
{

    public static function renderImage($url, $alt = false, $title = false, $class = false) {
        $pathinfo = pathinfo($url);
        $acceptedFormats = array('gif', 'png', 'jpg', 'svg');
        if(!isset($pathinfo['filename']) || empty($pathinfo['filename']) || !isset($pathinfo['extension']) || !in_array($pathinfo['extension'], $acceptedFormats)){
            $url = asset('/client/default-image.png');
        }
        ob_start();
        ?>
        <img src="<?php echo $url ?>" style="width: 100%" alt="<?php echo $alt ? $alt : ( isset($pathinfo['filename']) ? $pathinfo['filename'] : "" ) ?>" title="<?php echo $title ? $title : (isset($pathinfo['filename']) ? $pathinfo['filename'] : "" ) ?>" <?php echo $class ? 'class="'. $class . '"': false ?>/>
        <?php
        $content = ob_get_contents();
        ob_get_clean();
        return $content;
    }

}
