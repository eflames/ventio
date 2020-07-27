<?php

namespace App\Http\Controllers;

use App\Libraries\LicenseUtils;
use App\Models\Product;
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

    public function exportToWoocommerce(Request $request)
    {
		try{
			//Esto es una empanadita de codigo
			$this->authorize('config', User::class);
			$headers = array(
				"Content-type" => "text/csv",
				"Content-Disposition" => "attachment; filename=file.csv",
				"Pragma" => "no-cache",
				"Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
				"Expires" => "0"
			);
		
			$stock = Product::whereNested(function($query) use($request)
                {
                    if($request->category_id){
                        $query->where('product_category_id', $request->category_id);
                    }
                })
            ->orderBy('id', 'DESC')->get();

			$columns = ['Type', 'SKU', 'Name', 'Short description', 'Description', 'In stock?', 'Stock', 'Regular price', 'Categories'];
		
			$callback = function() use ($stock, $columns)
			{
				$file = fopen('php://output', 'w');
				fputcsv($file, $columns);
		
				foreach($stock as $item) {
					fputcsv($file, array('simple', $item->identifier, $item->name, $item->description, $item->description, $item->stock->sum('qty') > 0 ? 1 : 0, $item->stock->sum('qty'), $item->stock->avg('price') ?? 0, $item->category->name));
				}
				fclose($file);
			};
			return response()->streamDownload($callback, 'WooCommerce-' . date('d-m-Y-H:i:s').'.csv', $headers);
			
		}catch (\Exception $e){
			return view('errors.exception')->with('error', $e->getMessage());
		}
    
    }

    public function setLicense(Request $request){
        try{
            $this->authorize('config', User::class);
            $checkLicense = LicenseUtils::checkLicense($request->value);
            if($checkLicense){
                LicenseUtils::installLicense($request->value);
            }
            return redirect()->back();
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function showLicenseForm(){
        try{
            return view('auth.license');
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public function installLicense(Request $request){
        try{
            $checkLicense = LicenseUtils::checkLicense($request->value);
            if($checkLicense){
                LicenseUtils::installLicense($request->value);
                return redirect('login');
                die();
            }
            return back();
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }
}
