<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\testController;
use Illuminate\Support\Facades\Date;
use function PHPUnit\Framework\isEmpty;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('countAlp',function (Request $request) {
    // $stringAlp="aaabbcccddeddbzaa";
    $stringAlp=$request->get("input");
    $array=str_split($stringAlp);
    $resultArray=[];
    foreach ($array as $value) {
        try {
            $resultArray[$value]++;
        } catch (\Throwable $th) {
            $resultArray[$value]=1;
        }
    }
    $result="";
    foreach ($resultArray as $key => $value) {
        if($value!=1){
            $result.=$key.$value;
        }else{
            $result.=$key;  
        }
    }
    return $result;
});

Route::get('sorting',function (Request $request) {
    $array = json_decode($request->get("input"));
    for ($i=0; $i <count($array) ; $i++) { 
        for ($j=$i; $j <count($array) ; $j++) {
            if($array[$i]>$array[$j]){
                $tempI= $array[$i];
                $array[$i]=$array[$j];
                $array[$j]=$tempI;
            }
        } 
    }
    return $array;
});

Route::get('diskon',function (Request $request) {
    $typeBarang=$request->get("tipe_barang");
    $harga["A"]=99900;
    $harga["B"]=49900;
    $jumlahBeli=$request->get("jumlah_barang");;
    $hargaTotal=$harga[$typeBarang]*$jumlahBeli;

    $day = date_format(Date::now(),'l');
    if($typeBarang=="A" && $jumlahBeli>50){
        $hargaTotal = $hargaTotal - ($hargaTotal/100*5);
        if($day=="Friday" && $day=="Monday"){
            $hargaTotal = $hargaTotal - ($hargaTotal/100*10);
        }
    }else if($typeBarang=="B" && $jumlahBeli>100){
        $hargaTotal = $hargaTotal - ($hargaTotal/100*10);
        if($day=="Friday"){
            $hargaTotal = $hargaTotal - ($hargaTotal/100*5);
        }
    }
    return $hargaTotal;
});
