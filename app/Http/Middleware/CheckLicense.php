<?php

namespace App\Http\Middleware;

use Closure;
use App\Libraries\LicenseUtils;

class CheckLicense
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(LicenseUtils::standaloneCheck()){
            return $next($request);
        }else{
            return redirect('license');
        }
    }
}
