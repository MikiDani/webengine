<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module_sendemail extends Model
{
    protected $table		= 'module_sendemail';
	protected $primaryKey	= 'id';
	public $timestamps		= true;

	protected $fillable = [
		'id_menumodulelist', 'sendemail_email', 'sendemail_label', 'sendemail_message',
	];
}
