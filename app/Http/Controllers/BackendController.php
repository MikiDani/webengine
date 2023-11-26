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

	public function admin_menus($menulistid = null) {

		print "menulistid";
		dump($menulistid);

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
				foreach ($menurow->connect_menumodulelist()->get() as $modulelistrow)
				{
					if ($modulelistrow->id_moduletype == 1)
						$menumodulelist[$menurow->id][$modulelistrow->id] = [
							'typeid' => $modulelistrow->id_moduletype,
							'typename' =>  Menumoduletype::find($modulelistrow->id_moduletype)->name,
							'sequence' => $modulelistrow->sequence,
							'modulename_hu' => $modulelistrow->modulename_hu,
							'modulename_en' => $modulelistrow->modulename_en,
							'value' => Module_news::where('id_menumodulelist', $modulelistrow->id)->get()
						];
					
					if ($modulelistrow->id_moduletype == 2)
						$menumodulelist[$menurow->id][$modulelistrow->id] = [
							'typeid' => $modulelistrow->id_moduletype,
							'typename' =>  Menumoduletype::find($modulelistrow->id_moduletype)->name,
							'sequence' => $modulelistrow->sequence,
							'modulename_hu' => $modulelistrow->modulename_hu,
							'modulename_en' => $modulelistrow->modulename_en,
							'value' => Module_sendemail::where('id_menumodulelist',	$modulelistrow->id)->get()
						];
				}
			}
		}		

		dump($menumodulelist);
		
		return view('backend.admin_menus', [
			'menulistid' => $menulistid,
			'moduletypes' => $moduletypes,
			'staticmenu' => $menuarray,
			'menulist' => $menulist,
			'menumodulelist' => $menumodulelist,
		]);
	}

	public function menus_save(Request $request)
	{
		// MENU & MENULIST SAVE
		if (true)
		{
			$menu = json_decode($request->menuarray);

			$menusql = Menulist::all()->toArray();

			$isset_ids = [];

			if ($menu !== null) {
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

				foreach ($menu as $menuelement)
				{
					$menuelement = get_object_vars($menuelement);
					recursive_getdata($menuelement, $menusql, $isset_ids);
				}

				Menulist::whereNotIn('id', $isset_ids)->delete();

				//Menu JSON inserted
				Menu::truncate();	// törli az előző tartalmat
				
				$insertedJsonData = [];

				foreach ($menu as $menu_row) {
					array_push($insertedJsonData, $menu_row);
				}

			} else {
				$insertedJsonData = null;
			}

			$menu = new Menu();
			$menu->menujson = json_encode($insertedJsonData);
			$menu->save();
		}
		
		// MENUMODULELIST SAVE
		if (true)
		{
			$sql_menulist_ids = Menulist::pluck('id');
			dump($sql_menulist_ids);
			Menumodulelist::whereNotIn('id_menulist', $sql_menulist_ids)->delete(); // !! Majd ell.

			$sql_modulelist = Menumodulelist::all()->toArray();
			$sql_modulelist_isd = Menumodulelist::pluck('id')->toArray();
			
			$actual_modulelist = $request->edit;
	
			print "SQL:";
			dump($sql_modulelist);
			print "ACTUAL:";
			dump($actual_modulelist);
			print "----";

			//dd('stop');

			foreach($actual_modulelist as $menulist_row_id => $menulist_row_value)
			{
				//$menulist_row_id
				$count_sequence = 0;
				foreach($menulist_row_value as $actual_modulelist_id => $actual_modulelist_row)
				{
					dump($actual_modulelist_id, $actual_modulelist_row);

					if (in_array($actual_modulelist_id, $sql_modulelist_isd))
					{
						print "van!";
						$sql_modulelist_row = Menumodulelist::find($actual_modulelist_id);
						$sql_modulelist_row->sequence = $count_sequence;
						$sql_modulelist_row->modulename_hu = $actual_modulelist_row['modulename_hu'];
						$sql_modulelist_row->modulename_en = $actual_modulelist_row['modulename_en'];
						$sql_modulelist_row->save();
					} else {
						print "nincsen!";
						$sql_modulelist_row = new Menumodulelist();
						$sql_modulelist_row->id_menulist = $menulist_row_id;
						$sql_modulelist_row->id_moduletype = $actual_modulelist_row['moduletype'];
						$sql_modulelist_row->sequence = $count_sequence;
						$sql_modulelist_row->modulename_hu = $actual_modulelist_row['modulename_hu'];
						$sql_modulelist_row->modulename_en = $actual_modulelist_row['modulename_en'];
						$sql_modulelist_row->save();
					}

					$count_sequence++;
					print "count: " . $count_sequence;
				}
				dump($menulist_row_id, $menulist_row_value);
			}

			// Menulist::whereNotIn('id', $isset_ids)->delete();

		}

		//dd('stop');
		if ($request->id_menulist == null)
			return back();
		else
			return redirect()->route('admin_menus', ['menulistid' => $request->id_menulist]);
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
