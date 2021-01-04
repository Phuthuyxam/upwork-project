<?php
namespace App\Modules\dashboard\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use App\Modules\Post\Repositories\PostRepository;


class DashboardController extends Controller{

    protected $posRepository;

//    public function __construct(PostRepository $posRepository){
//        //$this->posRepository = $posRepository;
//    }

    public function index(Request $request){
//        $get = $this->posRepository->getAll();
//        dump($get);
        return view('dashboard::dashboard');
    }

}
