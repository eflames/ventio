<?php

namespace App\Http\Controllers;

use App\Listeners\SuccessfulDatabaseBackup;
use App\User;
use Illuminate\Http\Request;
use App\Traits\SEO;
use Illuminate\Support\Facades\Artisan;

class SystemController extends Controller
{
    use SEO;

    public function dbbackup()
    {
        try{
            $this->authorize('config', User::class);
            Artisan::call('backup:run', ['--only-db' => true]);
            $msg = Artisan::output();
            if(session()->has('backup.name')){
                $eventResponse = explode("\\", session()->get('backup.name'));
                $msg = "<strong>El backup se ha realizado con éxito</strong>. Recomendamos 
                <a href='". url('backups/Ventio/' . end($eventResponse)) ."' class='btn btn-success'><span class='ft-download-cloud'></span> Descargar</a> el archivo comprimido 
                y almacenarlo fuera del equipo para mayor seguridad.";
                return redirect()->back()->with('message', $msg);
            }else{
                return redirect()->back()->with('error', $msg);
            }
            dd(session()->get('backup.name'));
            
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }
}
