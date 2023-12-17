<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Images;

class Appservice
{
    static public function image_operations($file, $width, $dir)
    {
        if (Auth::check() && Auth::user()->rank == 1) {

            $extension = $file->getClientOriginalExtension();
            
            $exts = ['jpg', 'jpeg', 'png'];
        
            if (!in_array($extension, $exts)) {

                if (Appservice::actual_language() == 'hu')
                    $message = 'Csak jpg és png kiterjesztésű képeket lehet feltölteni!';
                elseif (Appservice::actual_language() == 'en')
                    $message = 'Only images with jpg and png extensions can be uploaded!';
                else
                    $message = 'Error!';

                return [
                    'status' => false,
                    'message' => $message,
                ];
            }
            
            if ($extension === 'png') {
                $image = imagecreatefrompng($file->getPathname());
            } else {
                $image = imagecreatefromjpeg($file->getPathname());
            }
            
            $height = null;
            list($originalwidth, $originalheight) = getimagesize($file->getPathname());
            $height = $width * $originalheight / $originalwidth;
        
            $resizedimage = imagecreatetruecolor($width, $height);
            imagecopyresampled($resizedimage, $image, 0, 0, 0, 0, $width, $height, $originalwidth, $originalheight);
            ob_start();
            
            if ($extension === 'png') {
                imagepng($resizedimage);
            } else {
                imagejpeg($resizedimage);
            }
        
            $imagedata = ob_get_clean();

            $min = 11111111; $max = 99999999; $randomNumber = mt_rand($min, $max);
            $randomString = (string)$randomNumber;
            $newfilename = time().'_'.$randomString.'.'.$extension;
            $path = 'public/'.$dir.'/'.$newfilename; //$file->getClientOriginalName()

            $upload = Storage::put($path, $imagedata);
        
            imagedestroy($image);
            imagedestroy($resizedimage);
        
            if ($upload !== false)
                return ['status' => true, 'newfilename' => $newfilename];
            else
                return ['status' => false];
        }

        return ['status' => false];
    }

    static public function checkanddelete_images($delids)
    {
        if (Auth::check() && Auth::user()->rank == 1) {
            foreach($delids as $key => $value)
            {
                if (Storage::disk('public')->exists('images/'.$value->imagename))
                    Storage::disk('public')->delete('images/'.$value->imagename);
                
                Images::find($value->id)->delete();
            }
        }
    }

    static public function actual_language()
    {
        return str_replace('_', '-', app()->getLocale());
    }
}