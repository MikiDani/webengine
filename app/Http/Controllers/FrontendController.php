<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use App\Models\Menumoduletype;
use App\Models\Menu;
use App\Models\Menulist;
use App\Models\Menumodulelist;
use App\Models\Module_news;
use App\Models\Module_sendemail;
use App\Models\Module_gallery;
use App\Models\Images;

class FrontendController extends Controller
{
	public function start() {
		session()->flash('message', Lang::get('messages.start.textwelcome'));
		return view('frontend');
	}

	// API

	public function loadData($menulistid = null) {
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
					// COMMON DATA
					$menumodulelist[$menurow->id][$modulelistrow->id] = [
						'typeid' => $modulelistrow->id_moduletype,
						'typename' =>  Menumoduletype::find($modulelistrow->id_moduletype)->name,
						'sequence' => $modulelistrow->sequence,
						'modulename_hu' => $modulelistrow->modulename_hu,
						'modulename_en' => $modulelistrow->modulename_en,
					];

					if ($modulelistrow->id_moduletype == 1)
						$menumodulelist[$menurow->id][$modulelistrow->id]['value'] = Module_news::where('id_menumodulelist', $modulelistrow->id)->get();

					if ($modulelistrow->id_moduletype == 2)
						$menumodulelist[$menurow->id][$modulelistrow->id]['value'] = Module_sendemail::where('id_menumodulelist', $modulelistrow->id)->get();
					
					if ($modulelistrow->id_moduletype == 3)
						$menumodulelist[$menurow->id][$modulelistrow->id]['value'] = Module_gallery::where('id_menumodulelist', $modulelistrow->id)->get();
				}
			}
		}

		$data = [
			'menulistid' => $menulistid,
			'moduletypes' => $moduletypes,
			'staticmenu' => $menuarray,
			'menulist' => $menulist,
			'menumodulelist' => $menumodulelist,
		];

		return $data;
	}
}
