<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module_news extends Model
{
    protected $table		= 'module_news';
	protected $primaryKey	= 'id';
	public $timestamps		= true;

	protected $fillable = [
		'id_menumodulelist', 'sequence', 'news_datetime', 'news_title', 'news_message', 'image_id', 'news_link',
	];
}
