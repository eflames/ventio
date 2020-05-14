<?php
namespace App\Libraries;

use Intervention\Image\Facades\Image;

class ImageUtil
{

    public function procImage($image){
        $img = Image::make($image);
            $maxWidth = 215;
            $maxHeight = 50;
            $width = $img->width();
            $height = $img->height();
            $vertical   = (($width < $height) ? true : false);
            $horizontal = (($width > $height) ? true : false);
            $square     = (($width = $height) ? true : false);
            if ($vertical) {
                $img->resize(null, $maxWidth / 2, function ($constraint) {
                    $constraint->aspectRatio();
                });
                
            } else if ($horizontal) {
                $img->resize($maxWidth, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else if ($square) {
                $img->resize(null, $maxHeight, function ($constraint) {
                    $constraint->aspectRatio();
                });
            }
            // $img->resizeCanvas($maxWidth, $maxHeight, 'center', false, '#ffffff');
            $img->save('images/logo.png');
    }

}