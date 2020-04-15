<?php
/**
 * Created by PhpStorm.
 * User: ernestoflames
 * Date: 17/9/18
 * Time: 11:14 PM
 */

namespace App\Traits;

use Artesaos\SEOTools\Facades\SEOMeta;

trait SEO
{
    public function setSeo($title = null)
    {
        SEOMeta::setTitle(str_limit($title,60));
    }
}