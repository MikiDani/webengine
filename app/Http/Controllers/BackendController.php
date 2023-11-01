<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;

class BackendController extends Controller
{
	public function admin_index() {

		return view('backend.admin_index');
	}

	public function admin_user() {

		return view('backend.admin_user');
	}

	public function admin_menus() {

		$menuall = Menu::all()->first();
		
		$menuarray = json_decode($menuall->menujson);
		
		return view('backend.admin_menus', [
			'staticmenu' => $menuarray,
		]);
	}

	public function menus_save(Request $request)
	{
		$menu_data = json_decode($request->menuarray);

		//dump($menu_data);
		
		Menu::truncate();	// törli az előző tartalmat

		$insertedJsonData = [];

		foreach ($menu_data as $menu_row) {
			array_push($insertedJsonData, $menu_row);
		}

		$menu = new Menu();
		$menu->menujson = json_encode($insertedJsonData);
		$menu->save();

		return back();
	}

	public function changelang(Request $request) {

		$lang = $request->lang;
		$validLanguages = ['en', 'hu'];

		if (!in_array($lang, $validLanguages))
			return back();

		$cookie = cookie('selected_language', $lang, 60 * 24 * 7);

		return back()->withCookie($cookie);
	}
}
