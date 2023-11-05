<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menulist extends Model
{
    protected $table		= 'menulist';
	protected $primaryKey	= 'id';
	public $timestamps		= true;

	protected $fillable = [
		'id_menu', 'menuname_hu', 'menuname_en',
	];
}
