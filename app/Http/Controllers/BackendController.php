<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BackendController extends Controller
{
    public function admin_index() {

        //dd(Auth::id());

        session()->flash('message', 'Welcome to backend.admin_index page!');

        return view('backend.admin_index');
    }

    public function admin_index_two() {

        session()->flash('message', 'Welcome to backend.admin_index_two page!');

        return view('backend.admin_index_two');
    }
}
