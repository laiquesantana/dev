<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Auth::routes();

Route::group(['middleware' => 'auth'], function() {
    Route::get('seguros-download/{id}', 'API\SeguroController@download');
    route::get('/{any}','HomeController@index')->where(' any', '.*');
 });
