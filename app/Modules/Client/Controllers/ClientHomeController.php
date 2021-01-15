<?php


namespace App\Modules\Client\Controllers;


use App\Core\Glosary\SeoConfigs;
use App\Core\Helper\OptionHelpers;
use App\Http\Controllers\Controller;
<<<<<<< Updated upstream
use App\Modules\Setting\Repositories\OptionRepository;
=======
use Spatie\SchemaOrg\Graph;
>>>>>>> Stashed changes

class ClientHomeController extends Controller
{

    protected $optionRepository;
    public function __construct(OptionRepository $optionRepository)
    {
        $this->optionRepository = $optionRepository;
    }
    public function index() {
        $systemConfig = OptionHelpers::getSystemConfigByKey('general');
        $seoConfig = SeoConfigs::getSeoKey();
        if($systemConfig && json_decode($systemConfig, true)){
            $systemConfig = json_decode($systemConfig, true);
        }
<<<<<<< Updated upstream

//        dd($systemConfig);
//        $seoDefault = [
//            'SEO' => [
//                'TITLE' => $systemConfig['site_title'],
//                'DESC' => $systemConfig['']
//
//            ]
//        ];

        $page = json_decode($this->optionRepository->getByKey('home')->option_value);
//        return view('Client::homepage',compact('seoDefault'));
        return view('Client::homepage',compact('page'));
=======
        $seoDefault = [
            $seoConfig['SEO']['FOCUS_KEYPHARE'] => $systemConfig['site_title'],
            $seoConfig['SEO']['TITLE'] => $systemConfig['site_title'],
            $seoConfig['SEO']['DESC'] => $systemConfig['site_tagline'],
            $seoConfig['SEO']['CANONICAL_URL'] => \url()->to("/"),
            $seoConfig['SOCIAL']['FACEBOOK']['TITLE'] => $systemConfig['site_title'],
            $seoConfig['SOCIAL']['FACEBOOK']['DESCRIPTION'] => $systemConfig['site_tagline'],
            'published_time' => '2021-01-05T06:39:17+00:00',
            'modified_time' => '2021-01-05T06:39:17+00:00',
            $seoConfig['SOCIAL']['FACEBOOK']['IMAGE'] => $systemConfig['logo'],
            $seoConfig['SOCIAL']['TWITTER']['TITLE'] => $systemConfig['site_title'],
            $seoConfig['SOCIAL']['TWITTER']['DESCRIPTION'] => $systemConfig['site_tagline'],
            $seoConfig['SOCIAL']['TWITTER']['IMAGE'] => $systemConfig['logo']
        ];
        return view('Client::homepage',compact('seoDefault'));
>>>>>>> Stashed changes
    }

}
