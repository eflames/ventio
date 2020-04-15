<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $config;

    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $items = Config::all();
        $users = User::pluck('name', 'email');
        $confArray = [];
        foreach ($items as $item) {
            if (!empty($item->key)) {
                $confArray[$item->key] = $item->value;
            }
        }
        $this->config = $confArray;
        view()->share('config', $confArray);
        view()->share('usersLogin', $users);
    }
}
