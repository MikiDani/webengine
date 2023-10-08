<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BackendController extends Controller
{
    public function admin_index() {

        return view('backend.admin_index');
    }

    public function admin_user() {

        return view('backend.admin_user');
    }

    public function admin_menus() {

        return view('backend.admin_menus');
    }
}
