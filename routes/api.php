<?php

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
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
use App\Http\Controllers\UserController;

Route::apiResource('users', UserController::class);

Route::get('/updateUserAuthorized/{user}', UserController::class.'@updateUserAuthorization');

Route::group(['prefix' => 'userType'], function () {
    Route::get('/', UserController::class. '@getAllUserType');
    Route::post('/update/{userType}/{user}', UserController::class.'@updateUserType');
});

