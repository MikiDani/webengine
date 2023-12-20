<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module_gallery extends Model
{
    protected $table		= 'module_gallery';
	protected $primaryKey	= 'id';
	public $timestamps		= true;

	protected $fillable = [
		'id_menumodulelist', 'image_id', 'sequence', 'picturename_hu', 'picturename_en', 'active',
	];
}
