<?php
namespace App\Modules\Dashboard\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Analytics;
use Spatie\Analytics\Period;

class DashboardController extends Controller{
    public function index(Request $request){

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
        $pageViewData = [];
        if($pageView && $pageView->isNotEmpty()){
            foreach ($pageView as $view) {
                $pageView['date'][] = $view->date;
                $pageView['page_view'][] = $view->pageViews;
            }
        }

        $topBrowser = Analytics::fetchTopBrowsers($oneYear);

        $topBrowserData = [];
        if($topBrowser && $topBrowser->isNotEmpty()){
            foreach ($topBrowser as $browser) {
                $pageView['browser'][] = $browser->pageViews;
            }
        }


        return view('Dashboard::dashboard', compact('pageViewData', 'topBrowser'));
    }

}
