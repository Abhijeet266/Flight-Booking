<?php
use App\Http\Controllers\FlightController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
/*Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::get("list/{id?}",[FlightController::class, 'list']);
    Route::post("add",[FlightController::class,'add']);
    Route::put("update",[FlightController::class,'update']);
    Route::get("search/{flight_name}",[FlightController::class,'search']);
    Route::delete("delete/{flight_id}", [FlightController::class,'delete']);
    Route::post("save",[FlightController::class,'testData']);
    });
// */
// Route::middleware('auth:api')->group(function(){
    Route::get("list/{id?}",[FlightController::class, 'list']);
    Route::post("add",[FlightController::class,'add']);
    Route::put("update/{id}",[FlightController::class,'update']);

    Route::get("search/{type}/{name}",[FlightController::class,'search']);

    //Route::get('searchGlobal/{name}', [FlightController::class, 'searchGlobal']);

    Route::delete("delete/{flight_id}", [FlightController::class,'delete']);
    Route::post("save",[FlightController::class,'testData']);
   // });
    //Route::post("add",[FlightController::class,'add']);
//Route::post("login",[UserController::class,'index']);
//Route::post('signup', [UserController::class, 'getdata']);
Route::post('import', [UserController::class, 'import']);
Route::get('export/{type}', [UserController::class, 'export']);

Route::post('/login',[UserController::class, 'login_user']);
Route::post('/signup',[UserController::class, 'register']);
