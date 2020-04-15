<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Traits\SEO;
use Illuminate\Support\Facades\Artisan;

class SystemController extends Controller
{
    use SEO;

    public function index()
    {
        try{
            $this->authorize('config', User::class);
            $this->setSeo('Sistema');
            return view('modules.system.list');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function dbbackup()
    {
        try{
            Artisan::call('backup:run');
            $msg = Artisan::output();
            return redirect()->route('system.index')->with('message', $msg);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }
}
