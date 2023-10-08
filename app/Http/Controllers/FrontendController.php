<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FrontendController extends Controller
{
    public function start() {
        session()->flash('message', 'Welcome to the page!');
        return view('frontend');
    }
}
