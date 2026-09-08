<?php
namespace App\Libraries;

use Intervention\Image\Laravel\Facades\Image;

class ImageUtil
{

    public function procImage($image){
        $img = Image::read($image);
        $maxWidth = 215;
        $maxHeight = 50;
        $width = $img->width();
        $height = $img->height();
        $vertical = (($width < $height) ? true : false);
        $horizontal = (($width > $height) ? true : false);
        $square = (($width == $height) ? true : false);
        if ($vertical) {
            $img->scale(height: $maxWidth / 2);
        } else if ($horizontal) {
            $img->scale(width: $maxWidth);
        } else if ($square) {
            $img->scale(height: $maxHeight);
        }
        $img->save(public_path('images/logo.png'));
    }

}
