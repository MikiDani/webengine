<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use app\Models\Module_switch;

class Menumodulelist extends Model
{
    protected $table		= 'menumodulelist';
	protected $primaryKey	= 'id';
	public $timestamps		= true;

	protected $fillable = [
		'sequence', 'modulename_hu', 'modulename_en', 'id_menulist', 'id_moduletype',
	];
}
