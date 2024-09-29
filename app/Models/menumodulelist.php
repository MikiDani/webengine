<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menumodulelist extends Model
{
    protected $table		= 'menumodulelist';
	protected $primaryKey	= 'id';
	public $timestamps		= true;

	protected $fillable = [
		'id_menulist', 'id_moduletype', 'sequence', 'modulename_hu', 'modulename_en',
	];
}
