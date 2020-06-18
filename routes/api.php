<?php

use Illuminate\Http\Request;

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

// Route::group([  'namespace' => 'Cgm',     
//                 ], function () {

//     Route::post('cgm/',                 ['uses' => 'CgmController@cadastro']);
//     Route::get('validaemail/{email}',   ['uses' => 'CgmController@validaEmail']);

// });

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([  'namespace' => 'Site', 
                'middleware' => 'cors'
                ], function () {
    Route::get('/lecomAtualizaCgm/{chamado?}/{status?}',    'SiteController@lecomAtualizaCgm')->name('lecomAtualizaCgm');
    
});