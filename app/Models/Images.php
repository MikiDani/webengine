<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Services\Appservice;

class Images extends Model
{
    protected $table		= 'images';
	protected $primaryKey	= 'id';
	public $timestamps		= true;

	protected $fillable = [
		'id_menulist', 'id_menumodulelist', 'id_module', 'imagename', 'sequence', 'first'
	];

	static public function image_upload($menuid, $moduleid, $rowid, $file, $uploadimagesize)
	{
		$new_image_id = false;
	
		// Upload Image
		$response = Appservice::image_operations($file, $uploadimagesize, 'images');

		if (!$response['status'])
		{	
			return [
				'status' => false,
				'message' => $response['message'],
			];
		}
		else
		{
			$newfilename = $response['newfilename'];

			$newimage = new Images();

			$newimage->id_menulist = $menuid;
			$newimage->id_menumodulelist = $moduleid;
			$newimage->id_module = $rowid;
			$newimage->imagename = $newfilename;
			$newimage->save();

			$new_image_id = $newimage->id;

			return [
				'status' => true,
				'newfilename' => $response['newfilename'],
				'new_image_id' => $new_image_id,
			];
		}
	}

	static public function deletepicture_action($menuid, $moduleid, $rowid, $modulerow)
	{
		$success = false;

		if (isset(Images::find($modulerow->image_id)->imagename) && Storage::disk('public')->exists('images/'.Images::find($modulerow->image_id)->imagename))
		{
			$success = true;
			// Delete image hardware
			Storage::disk('public')->delete('images/'.Images::find($modulerow->image_id)->imagename);	
		}

		// Delete image Images table
		$image = Images::find($modulerow->image_id);
		if ($image)
			$image->delete();
		
		if ($success)
		{
			if (Appservice::actual_language() == 'hu') $message = 'Sikeres képtörlés.'; elseif (Appservice::actual_language() == 'en') $message = `Image deleted successfully.`;
			else $message = 'Successfully!';
			
			return $message;
		}
		else
		{
			if (Appservice::actual_language() == 'hu') $message = 'Hiba a kép törlésekor. A kép már nem létezett fizikailag!'; elseif (Appservice::actual_language() == 'en') $message = `Error deleting image. The picture no longer existed!`;
			else $message = 'Error!';

			return $message;
		}
	}
}
