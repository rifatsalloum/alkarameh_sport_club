<?php

use App\Http\Controllers\AssociationController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\AllInOneController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BossController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\SeasoneController;
use App\Http\Controllers\StandingController;
use App\Http\Controllers\MatcheController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\PrimeController;
use App\Http\Controllers\ReplacmentController;
use App\Http\Controllers\SportController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\TopFanController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\WearController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
| https://alkarameh.cliprz.org/api
*/

Route::get("museum",[AllInOneController::class,"museum"]);
Route::get("stuff",[AllInOneController::class,"stuff"]);
Route::get("sport/all",[SportController::class,"index"]);
Route::get("seasone/all",[SeasoneController::class,"index"]);
Route::post("standing",[StandingController::class,"index"]);
Route::post("matches/finished",[MatcheController::class,"finishedMatches"]);
Route::post("matches/not/started",[MatcheController::class,"notStartedMatches"]);
Route::post("next/matche",[MatcheController::class,"nextMatche"]);
Route::post("matche/details",[MatcheController::class,"matcheDetails"]);
Route::get("news/all",[InformationController::class,"allNews"]);
Route::post("player/details",[PlayerController::class,"show"]);
Route::get("associations",[AssociationController::class,"index"]);
Route::post("club/all",[ClubController::class,"index"]);
Route::get("player/all",[PlayerController::class,"index"]);
Route::post("matche/beanched/players",[PlanController::class,"getBeanchedPlayers"]);
Route::post("matche/main/players",[PlanController::class,"getMainPlayers"]);
Route::post("send/email",[UserController::class,"sendEmail"]);


Route::post("login",[UserController::class,"login"]);

Route::group(["middleware" => ["token_auth"]],function() {
Route::post("sport/add",[SportController::class,"store"]);
Route::post("sport/update",[SportController::class,"update"]);
Route::post("seasone/add",[SeasoneController::class,"store"]);
Route::post("club/add",[ClubController::class,"store"]);
Route::post("club/update",[ClubController::class,"update"]);
Route::post("boss/add",[BossController::class,"store"]);
Route::post("boss/update",[BossController::class,"update"]);
Route::post("employee/add",[EmployeeController::class,"store"]);
Route::post("employee/update",[EmployeeController::class,"update"]);
Route::post("association/add",[AssociationController::class,"store"]);
Route::post("association/update",[AssociationController::class,"update"]);
Route::post("topfan/add",[TopFanController::class,"store"]);
Route::post("video/add",[VideoController::class,"store"]);
Route::post("video/update",[VideoController::class,"update"]);
Route::post("information/add",[InformationController::class,"store"]);
Route::post("information/update",[InformationController::class,"update"]);
Route::post("prime/add",[PrimeController::class,"store"]);
Route::post("player/add",[PlayerController::class,"store"]);
Route::post("player/update",[PlayerController::class,"update"]);
Route::post("matche/add",[MatcheController::class,"store"]);
Route::post("matche/update",[MatcheController::class,"update"]);
Route::post("plan/add",[PlanController::class,"store"]);
Route::post("replacement/add",[ReplacmentController::class,"store"]);
Route::post("statistc/add",[StatisticController::class,"store"]);
Route::post("statistic/update",[StatisticController::class,"update"]);
Route::post("standing/add",[StandingController::class,"store"]);
Route::post("standing/update",[StandingController::class,"update"]);
Route::post("wear/add",[WearController::class,"store"]);
Route::post("wear/update",[WearController::class,"update"]);
Route::post("logout",[UserController::class,"logout"]);
});