<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menu';
	protected $primaryKey = 'id';
	public $timestamps = true;
    protected $fillable = ['menujson'];
    protected $casts = [
        'menujson' => 'array',
    ];
    public static function savemenu($menu_data)
    {
        foreach ($menu_data as $menu_row) {
		    $menu = new Menu();
		    $menu->menujson = json_encode($menu_row);
		    $menu->save();
		}
    }
}
