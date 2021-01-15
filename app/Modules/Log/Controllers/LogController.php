<?php


namespace App\Modules\Log\Controllers;


use App\Http\Controllers\Controller;

class LogController extends Controller
{
    public function index(){

        return view('Log::index');
    }
}
