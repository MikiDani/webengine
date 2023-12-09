<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Services\Appservice;
use App\Models\Menumoduletype;
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

		//dump($menumodulelist);
		
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
					// REWRITE
					if($menuelement['id'] == $menurowsql['id'])
					{
						$no_finding = false;
						$upwrite_row = Menulist::find($menurowsql['id']);
						$upwrite_row->menuname_hu = $menuelement['menuname_hu'];
						$upwrite_row->menuname_en = $menuelement['menuname_en'];
						$upwrite_row->save();
					}
				}
				// CREATEING
				if($no_finding)
				{
					Menulist::create([
						'id' => $menuelement['id'],
						'menuname_hu' => $menuelement['menuname_hu'],
						'menuname_en' => $menuelement['menuname_en'],
					]);
				}
				// RECURSIVE CHILD			
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
			Menu::truncate();	// DELETE ALL DATA
			
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
		
		// MENUMODULELIST SAVE
		$sql_menulist_ids = Menulist::pluck('id');
		// delete not issets menumodules
		Menumodulelist::whereNotIn('id_menulist', $sql_menulist_ids)->delete();

		$sql_modulelist = Menumodulelist::all()->toArray();
		$sql_modulelist_isd = Menumodulelist::pluck('id')->toArray();
		
		$actual_modulelist = $request->edit;
		$isset_list = [];

		if($actual_modulelist)
		{
			foreach($actual_modulelist as $menulist_row_id => $menulist_row_value)
			{
				//$menulist_row_id
				$count_sequence = 0;

				foreach($menulist_row_value as $actual_modulelist_id => $actual_modulelist_row)
				{	
					if (in_array($actual_modulelist_id, $sql_modulelist_isd))
					{
						// ISSET
						array_push($isset_list, $actual_modulelist_id);
						$sql_modulelist_row = Menumodulelist::find($actual_modulelist_id);
						$sql_modulelist_row->sequence = $count_sequence;
						$sql_modulelist_row->modulename_hu = $actual_modulelist_row['modulename_hu'];
						$sql_modulelist_row->modulename_en = $actual_modulelist_row['modulename_en'];
						$sql_modulelist_row->save();
					} else {
						// CREATE
						array_push($isset_list, $actual_modulelist_id);
						$sql_modulelist_row = new Menumodulelist();
						$sql_modulelist_row->id_menulist = $menulist_row_id;
						$sql_modulelist_row->id_moduletype = $actual_modulelist_row['moduletype'];
						$sql_modulelist_row->sequence = $count_sequence;
						$sql_modulelist_row->modulename_hu = $actual_modulelist_row['modulename_hu'];
						$sql_modulelist_row->modulename_en = $actual_modulelist_row['modulename_en'];
						$sql_modulelist_row->save();
					}
					$count_sequence++;
				}
			}
		}
	
		$sql_left = array_diff($sql_modulelist_isd, $isset_list);
		Menumodulelist::whereIn('id', $sql_left)->delete();

		// IF SELECTED MENULIST ELEMENT
		$isset_menulist_id = Menulist::find($request->id_menulist);

		if ($request->id_menulist !== null && $isset_menulist_id !== null) {
			return redirect()->route('admin_menus', ['menulistid' => $request->id_menulist]);
		} else {
			return back();
		}
	}

	public function admin_module($menuid = null, $moduleid = null)
	{
		if ($menuid == null || $moduleid == null)
			return redirect()->route('admin_menus');
		
		$menu = Menulist::where('id', $menuid)->first()->toArray();
		$module = Menumodulelist::where('id', $moduleid)->where('id_menulist', $menuid)->first();
		$moduletype = Menumoduletype::find($module->id_moduletype)->toArray();
		
		if ($module == null)
			return redirect()->route('admin_menus');
	
		$module = $module->toArray();

		// NEWS MODULE
		if ($module['id_moduletype'] == 1)
		{
			$moduledata = Module_news::where('id_menumodulelist', $moduleid)->orderBy('sequence', 'asc')->get()->toArray();
			$last_sequence = Module_news::where('id_menumodulelist', $moduleid)->max('sequence');
		}
		else if ($module['id_moduletype'] == 2)
		{
			$moduledata = Module_sendemail::where('id_menumodulelist', $moduleid)->get()->toArray();
		} 
		else
			return back();

		return view('backend.modules.admin_indexmodule', [
			'menu' => $menu,
			'module' => $module,
			'moduletype' => $moduletype,
			'moduledata' => $moduledata,
			'last_sequence' => $last_sequence,
		]);
	}

	public function admin_module_save(Request $request, $menuid, $moduleid, $type = false)
	{

		//dd($menuid, $moduleid, $type);

		if (!$request->filled('moduletype'))
			return back();

	// NEWS MODULE
		if ($request->filled('moduletype') == 'news')
		{	
			if ($type == 'new')
			{
				if (!$request->filled('new_title') || !$request->filled('new_message') || !$request->filled('new_date') || !$request->filled('new_link'))
				{
					if (Appservice::actual_language() == 'hu') $message = 'Hibás kitöltés!'; elseif (Appservice::actual_language() == 'en') $message = 'Incorrect filling!';
						else $message = 'Error!';
	
					session()->flash('message', $message);
	
					return back();
				}
	
				$newfilename = null;
	
				if ($request->hasFile('new_image'))
				{
					$file = $request->file('new_image');
	
					// Upload Image
					$response = Appservice::image_operations($file, 600, 'storage_news');
	
					if (!$response['status'])
					{
						session()->flash('message', $response['message']);
						return back();
					}
					else
					{
						$newfilename = $response['newfilename'];
					}
				}
	
				$new_newsrow = new Module_news();
				
				$sequence = intval($request->last_sequence) + 1;
	
				$new_newsrow->sequence = $sequence;
				$new_newsrow->id_menumodulelist = $moduleid;
				$new_newsrow->news_datetime = date('Y-m-d', strtotime($request->new_date));
				$new_newsrow->news_title = $request->new_title;
				$new_newsrow->news_message = $request->new_message;
				$new_newsrow->news_link = $request->new_link;
				if ($newfilename)
					$new_newsrow->news_image = $newfilename;
	
				$new_newsrow->save();
	
				return back();

			} 
			else if($type == 'edit')
			{
				//dd($request->all()['edit']);
				//dd($request->all(), $menuid, $moduleid);
				
				if(!empty($request->all()['edit']))
				{
					dump($request->all()['edit']);
					$sequence = 1;
					foreach($request->all()['edit'] as $id => $editrow)
					{
						$actual_newsrow = Module_news::find($id);

						$actual_newsrow['sequence'] = $sequence;
						$actual_newsrow['news_datetime'] = $editrow['date'];
						$actual_newsrow['news_title'] = $editrow['title'];
						$actual_newsrow['news_message'] = $editrow['message'];
						$actual_newsrow['news_link'] = $editrow['link'];
						
						$actual_newsrow->save();

						$sequence++;
					}
				}
				
				return back();
			}

		// SEND EMAIL MODULE
		} else if ($request->filled('moduletype') == 'sendemail')
		{
			dd('SENDEMAIL');
			// ....
		}
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
