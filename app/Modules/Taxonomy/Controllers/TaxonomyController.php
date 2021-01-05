<?php
namespace App\Modules\Taxonomy\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaxonomyController extends Controller{
//    public function index(Request $request){
//        return view('Taxonomy::add');
//    }

    public function add(Request $request) {
        return view('Taxonomy::add');
    }
}
