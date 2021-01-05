<?php
namespace App\Modules\Debug\Controllersold;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use App\Modules\Post\Repositories\PostRepository;


class DebugController extends Controller{

    protected $posRepository;

//    public function __construct(PostRepository $posRepository){
//        //$this->posRepository = $posRepository;
//    }

    public function index(Request $request){
//        $get = $this->posRepository->getAll();
//        dump($get);
        dump("asdad");
    }

    public function edit() {
        dd('edit - Debug');
    }

    public function delete() {
        dd('delete - Debug');
    }

}
