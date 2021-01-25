<?php
namespace App\Modules\Dashboard\Controllers;

use App\Core\Glosary\PageTemplateConfigs;
use App\Http\Controllers\Controller;
use App\Modules\Permission\Repositories\RoleRepository;
use App\Modules\Post\Repositories\PostRepository;
use App\Modules\User\Repositories\UserRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Analytics;
use Spatie\Analytics\Period;

class DashboardController extends Controller{

    protected $posRepository;
    protected $userRepository;
    protected $roleRepository;
    public function __construct(PostRepository $posRepository, UserRepository $userRepository,RoleRepository $roleRepository)
    {
        $this->posRepository = $posRepository;
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }
    public function index(Request $request){

        $hotels = $this->posRepository->getInstantModel()->where('post_type',PageTemplateConfigs::POST['NAME'])->count();
        $users = $this->userRepository->getInstantModel()->where('role','<>','-99')->count();
        $roles = $this->roleRepository->getAll()->count();
        $pageViewData = [];
        $topBrowser = [];
        if (env('ANALYTICS_VIEW_ID')) {
            //        $analyticsData = new Analytics();
            $startDate = Carbon::now()->subYear();
            $endDate = Carbon::now();
            $oneYear =  Period::create($startDate, $endDate);
            $pageView = Analytics::fetchTotalVisitorsAndPageViews(Period::days(7));
//        $pageView = [
//          'date' => ['one','true','three','four','five'],
//            'page_view' => [1, 2 , 3 , 4, 5]
//        ];
            $c = json_encode($pageView);

            if($pageView && $pageView->isNotEmpty()){
                foreach ($pageView as $view) {
                    // dd($view['date']);
                    $pageViewData['date'][] = $view['date']->format('Y-m-d');
                    $pageViewData['page_view'][] = $view['pageViews'];
                }
            }
            $topBrowser = Analytics::fetchTopBrowsers($oneYear);

            $topBrowserData = [];
            if($topBrowser && $topBrowser->isNotEmpty()){
                foreach ($topBrowser as $browser) {
                    $pageView['browser'][] = $browser->pageViews;
                }
            }
        }
        return view('Dashboard::dashboard', compact('pageViewData', 'topBrowser','hotels','users','roles'));
    }

}
