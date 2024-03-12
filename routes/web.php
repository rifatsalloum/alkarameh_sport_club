<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("/cview",function(){
    return view("cview");
});
Route::post("/run",function (Request $request){
    \Illuminate\Support\Facades\Artisan::call($request->command);
    return "Command Excecuted Successfully!";
})->name("run");

Route::get("/run-seeders",function(){
    \Illuminate\Support\Facades\Artisan::call("db:seed",["--class"=>"AdminSeeder"]);
    return "Seeder Excecuted Successfully!";
});

Route::get("/update-app",function(){
    exec("composer dump-autoload");
    return "App Updated Successfully!";
});