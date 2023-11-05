<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menumodulelist extends Model
{
    protected $table		= 'menumodulelist';
	protected $primaryKey	= 'id';
	public $timestamps		= true;

	protected $fillable = [
		'sequence', 'id_menulist', 'id_moduletype',
	];
}
