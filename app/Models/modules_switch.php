<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module_switch extends Model
{
    protected $table		= 'module_switch';
	protected $primaryKey	= 'id';
	public $timestamps		= true;

	protected $fillable = [
		'id_modulelist', 'id_module',
	];
}
