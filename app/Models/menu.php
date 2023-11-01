<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu';
	protected $primaryKey = 'id';
	public $timestamps = true;
    protected $fillable = ['menujson'];
    protected $casts = [
        'menujson' => 'array',
    ];

    public static function staticmenu()
    {
        $staticmenu = [
			[
				'id' => 0,
				'name' => 'tangerine',
				'seq' => '1',
				'child' => [
					[
						'id' => 1,
						'name' => 'tomato',
						'seq' => '1',
						'child' => [
							[
								'id' => 2,
								'name' => 'kumquat',
								'seq' => '1',
							],
							[
								'id' => 3,
								'name' => 'avocado',
								'seq' => '2',
							],
						],
					],
					[
						'id' => 4,
						'name' => 'pomegranate',
						'seq' => '2',
					],
				],
			],
			[
				'id' => 5,
				'name' => 'banana',
				'seq' => '2',
				'child' => [
					[
						'id' => 6,
						'name' => 'lime',
						'seq' => '2',
						'child' => [
							[
								'id' => 7,
								'name' => 'raspberry',
							],
							[
								'id' => 8,
								'name' => 'apricot',
							],
						],
					],
				],
			],
			[
				'id' => 9,
				'name' => 'kiwi',
				'seq' => '3',
			],
		];

        return $staticmenu;
    }

    public static function savemenu($menu_data)
    {
        foreach ($menu_data as $menu_row) {
		    $menu = new Menu();
		    $menu->menujson = json_encode($menu_row);
		    $menu->save();
		}
    }
}
