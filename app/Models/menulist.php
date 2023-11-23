<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Menumodulelist;
use App\Models\Module_switch;

class Menulist extends Model
{
    protected $table		= 'menulist';
	public $primaryKey		= 'id';	// protected volt
	public $timestamps		= true;

	protected $fillable = [
		'id', 'menuname_hu', 'menuname_en',
	];

	public function connect_menumodulelist()
	{
		return $this->hasMany(Menumodulelist::class, 'id_menulist')->orderBy('sequence', 'asc');
	}
}
