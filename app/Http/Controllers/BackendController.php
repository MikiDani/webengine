<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Menulist;
use App\Models\Menumodulelist;

class BackendController extends Controller
{
	public function admin_index() {

		return view('backend.admin_index');
	}

	public function admin_user() {

		return view('backend.admin_user');
	}

	public function admin_menus() {

		// menuall
		$menuall = Menu::all()->first();
				
		if($menuall !== null)
			$menuarray = json_decode($menuall->menujson);
		else
			$menuarray = [];

		
		// $modulelistelements = [];
		// // menulist all
		// $getmenulist = Menulist::all();
		// foreach($getmenulist as $menuelement) {
		// 	//dump($menuelement->id_menu);
		// 	$row = Menumodulelist::where('id_menulist', $menuelement->id_menu)->get();
		// 	$modulelistelements[$menuelement->id_menu] = $row;
		// }
		// dump($modulelistelements);






		
		// $let = Menumodulelist::where('id_menulist', '1')->get();

		// dump($let);

		// dd('stop');

		return view('backend.admin_menus', [
			'staticmenu' => $menuarray,
		]);
	}

	public function menus_save(Request $request)
	{
		$menu_data = json_decode($request->menuarray);

		Menu::truncate(); // törli az előző tartalmat

		if ($menu_data !== null) {

			// menulist inserted
			Menulist::query()->delete();
			function recursive_getdata($menuelement)
			{
				Menulist::create([
					'id_menu' => $menuelement['id'],
					'menuname_hu' => $menuelement['menuname_hu'],
					'menuname_en' => $menuelement['menuname_en'],
				]);
				
				if (isset($menuelement['child']))
					foreach($menuelement['child'] as $childelement)
					{
						$childelement = get_object_vars($childelement);
						recursive_getdata($childelement);
					}
			}
			foreach ($menu_data as $menuelement)
			{
				$menuelement = get_object_vars($menuelement);
				recursive_getdata($menuelement);
			}

			//menu json inserted 
			$insertedJsonData = [];

			foreach ($menu_data as $menu_row) {
				array_push($insertedJsonData, $menu_row);
			}
		} else {
			$insertedJsonData = null;
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

		$cookie = cookie('selected_language', $lang, 60 * 24 * 7);	// 1 hét

		return back()->withCookie($cookie);
	}
}
