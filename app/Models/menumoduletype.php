<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menumoduletype extends Model
{
    protected $table		= 'menumoduletype';
	protected $primaryKey	= 'id';
	public $timestamps		= true;

	protected $fillable = [
		'name',
	];
}
