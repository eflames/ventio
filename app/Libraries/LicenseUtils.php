<?php

namespace App\Libraries;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Carbon;
use App\Models\License as LicenseModel;
use App\Models\Config;
use Illuminate\Http\Request;

class LicenseUtils{

    public static function checkLicense($hash){
        try{
            $decruptdvalue = decrypt($hash);
        }catch(DecryptException $e){
            session(['error' => 'El hash de la licencia no es correcto.']);
            // return redirect()->back()->with('error', 'El hash de la licencia ingresada no es correcto.');
            return false;
        }
        $section = explode('-', $decruptdvalue);
        if($section[1] <> 'Ernesto Flames'){
            session(['error' => 'El hash de la licencia es inválido.']);
            return false;
        }
        $today = Carbon::today();
        $licenseDate = Carbon::createFromFormat('d/m/Y', $section[2]);
        if($licenseDate->lessThan($today)){
            session(['error' => 'El hash de la licencia está vencido.']);
            return false;
        }
        return true;
    }

    public static function installLicense($hash){
        try{
            $value = decrypt($hash);
            $section = explode('-', $value);
            Config::where('key', 'store_name')->update(['value' => $section[0]]);
            LicenseModel::where('id', 1)->update(['value' => $hash]);
            session(['message' => 'La licencia ha sido aceptada a nombre de '. $section[0] . '. Gracias por usar Ventio.']);
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public static function warning(){
        try{
            $response = false;
            $hash = LicenseModel::findOrFail(1);
            $value = decrypt($hash->value);
            $section = explode('-', $value);
            $licenseDate = Carbon::createFromFormat('d/m/Y', $section[2]);
            $today = Carbon::today();
            if($licenseDate->diffInDays($today) < 16){
                $response = true;
            }
            return $response;
        }catch (\Exception $e){
            return view('errors.exception')->with('error', $e->getMessage());
        }
    }

    public static function standaloneCheck(){
            $hash = LicenseModel::findOrFail(1);
            return self::checkLicense($hash->value);
            // try{
            //     $value = decrypt($hash->value);
            // }catch(DecryptException $e){
            //     return false;
            // }
            // $section = explode('-', $value);
            // if($section[1] <> 'Ernesto Flames'){
            //     return false;
            // }
            // $today = Carbon::today();
            // $licenseDate = Carbon::createFromFormat('d/m/Y', $section[2]);
            // if($licenseDate->lessThan($today)){
            //     return false;
            // }
    }
}