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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix'=>'meja'], function(){
    Route::get('/all', 'App\Http\Controllers\Api\MejaController@getAllMeja');
    Route::get('/{id}', 'App\Http\Controllers\Api\MejaController@getMeja');
    Route::post('/create', 'App\Http\Controllers\Api\MejaController@createMeja');
    Route::post('/edit/{id}', 'App\Http\Controllers\Api\MejaController@updateMeja');
    Route::delete('/delete/{id}', 'App\Http\Controllers\Api\MejaController@destroyMeja');
});

Route::group(['prefix'=>'menu'], function(){
    Route::get('/all', 'App\Http\Controllers\Api\MenuController@getAllMenu');
    Route::get('/{id}', 'App\Http\Controllers\Api\MenuController@getMenu');
    Route::post('/create', 'App\Http\Controllers\Api\MenuController@createMenu');
    Route::post('/edit/{id}', 'App\Http\Controllers\Api\MenuController@updateMenu');
    Route::delete('/delete/{id}', 'App\Http\Controllers\Api\MenuController@destroyMenu');
});

