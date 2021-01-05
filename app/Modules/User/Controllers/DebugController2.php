<?php


namespace App\Modules\Debug\Controllersold;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DebugController2
{
    public function index(Request $request){
//        $get = $this->posRepository->getAll();
//        dump($get);
        dump("index - Debug 2");
    }

    public function edit() {
        dd('edit - Debug2');
    }

    public function delete() {
        dd('delete - Debug2');
    }
}
