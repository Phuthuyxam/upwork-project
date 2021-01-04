<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DebugController extends Controller
{
    public function index() {
        dd("index - Debug");
    }
    public function edit() {
        dd('edit - Debug');
    }

    public function delete() {
        dd('delete - Debug');
    }
}
