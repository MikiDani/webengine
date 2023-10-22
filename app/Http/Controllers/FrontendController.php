<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;

class FrontendController extends Controller
{
	public function start() {
		session()->flash('message', Lang::get('messages.start.textwelcome'));
		return view('frontend');
	}
}
