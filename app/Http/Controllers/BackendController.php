<?php

namespace App\Http\Controllers;

use App\Models\Menumoduletype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Menu;
use App\Models\Menulist;
use App\Models\Menumodulelist;
use App\Models\Module_news;
use App\Models\Module_sendemail;

class BackendController extends Controller
{
	public function admin_index() {

		return view('backend.admin_index');
	}

	public function admin_user() {

		return view('backend.admin_user');
	}

	public function admin_menus() {

		$moduletypes = Menumoduletype::all();

		// menuall
		$menuall = Menu::all()->first();
		
		if($menuall !== null)
			$menuarray = json_decode($menuall->menujson);
		else
			$menuarray = [];

		$menulist = Menulist::all();

		$menumodulelist = [];
		if ($menulist->isNotEmpty()) {

			foreach ($menulist as $menurow)
			{
				foreach ($menulist as $menurow)
				{
					foreach ($menurow->connect_menumodulelist()->get() as $modulelistrow)
					{
						if ($modulelistrow->id_moduletype == 1)
							$menumodulelist[$menurow->id][$modulelistrow->id] = ['typename' =>  Menumoduletype::find($modulelistrow->id_moduletype)->name, 'sequence' => $modulelistrow->sequence, 'modulename_hu' => $modulelistrow->modulename_hu, 'modulename_en' => $modulelistrow->modulename_en, 'value' => Module_news::where('id_menumodulelist', $modulelistrow->id)->get()];
						
						if ($modulelistrow->id_moduletype == 2)
							$menumodulelist[$menurow->id][$modulelistrow->id] = ['typename' =>  Menumoduletype::find($modulelistrow->id_moduletype)->name, 'sequence' => $modulelistrow->sequence, 'modulename_hu' => $modulelistrow->modulename_hu, 'modulename_en' => $modulelistrow->modulename_en, 'value' => Module_sendemail::where('id_menumodulelist', $modulelistrow->id)->get()];
					}
				}
			}
		}		

		dump($menumodulelist);
		
		//dd('stop');

		return view('backend.admin_menus', [
			'moduletypes' => $moduletypes,
			'staticmenu' => $menuarray,
			'menulist' => $menulist,
			'menumodulelist' => $menumodulelist,
		]);
	}

	public function menus_save(Request $request)
	{

		dd($request->all());

		$menu_data = json_decode($request->menuarray);

		$menusql = Menulist::all()->toArray();

		$isset_ids = [];

		if ($menu_data !== null) {
			// Menulist inserted
			function recursive_getdata($menuelement, $menusql, &$isset_ids)
			{
				array_push($isset_ids, intval($menuelement['id']));

				$no_finding = true;

				foreach($menusql as $menurowsql)
				{
					//REWRITE
					if($menuelement['id'] == $menurowsql['id'])
					{
						$no_finding = false;
						$upwrite_row = Menulist::find($menurowsql['id']);
						$upwrite_row->menuname_hu = $menuelement['menuname_hu'];
						$upwrite_row->menuname_en = $menuelement['menuname_en'];
						$upwrite_row->save();
					}
				}

				//CREATEING
				if($no_finding)
				{
					Menulist::create([
						'id' => $menuelement['id'],
						'menuname_hu' => $menuelement['menuname_hu'],
						'menuname_en' => $menuelement['menuname_en'],
					]);
				}
							
				if (isset($menuelement['child']))
				{
					foreach($menuelement['child'] as $childelement)
					{
						$childelement = get_object_vars($childelement);
						recursive_getdata($childelement, $menusql, $isset_ids);
					}
				}
			}

			foreach ($menu_data as $menuelement)
			{
				$menuelement = get_object_vars($menuelement);
				recursive_getdata($menuelement, $menusql, $isset_ids);
			}

			Menulist::whereNotIn('id', $isset_ids)->delete();

			//Menu JSON inserted
			Menu::truncate();	// törli az előző tartalmat
			
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
