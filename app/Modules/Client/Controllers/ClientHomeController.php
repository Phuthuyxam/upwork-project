<?php


namespace App\Modules\Client\Controllers;


use App\Http\Controllers\Controller;

class ClientHomeController extends Controller
{

    public function index() {
        $a = "Ádasda";
        return view('Client::homepage',compact('a'));
    }

}
