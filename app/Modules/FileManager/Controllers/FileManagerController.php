<?php

namespace App\Modules\FileManager\Controllers;

use App\Http\Controllers\Controller;

class FileManagerController extends Controller
{
    public function index() {
        return view('FileManager::index');
    }

    public function cktest() {
        return view('FileManager::cktest');
    }

}
