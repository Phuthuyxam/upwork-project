<?php


namespace App\Modules\Page\Controllers;


use App\Core\Glosary\PageTemplateConfigs;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class PageController extends Controller
{

    public function add() {
        return view('Page::add');
    }

    public function template(Request $request) {
        $template = $request->input('template');

        if ($template == PageTemplateConfigs::SERVICE['VALUE']) {
            $html = view(PageTemplateConfigs::SERVICE['VIEW'])->render();
            return response($html);
        }
    }
}
