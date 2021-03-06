<?php

use Illuminate\Http\Request;
use App\Http\Controllers\IC\Goods;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('GenerateData/{System}', 'BaseController@GenerateData');

//Goods
Route::get('TestAPI/', 'IC\Goods\GoodsController@TestAPI');
Route::post('BindLoadGoods', 'IC\Goods\GoodsController@BindLoadGoods');
Route::get('GetGoodsByBarcode/{GoodsBarCode}', 'IC\Goods\GoodsController@GetGoodsByBarcode');
Route::post('BindManageGoods', 'IC\Goods\GoodsController@BindManage');

//Unit
Route::get('GetUnit/', 'IC\Unit\UnitController@GetUnit');
