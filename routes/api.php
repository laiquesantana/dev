<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('segurados', 'API\SeguradosController');

    // get user profile
    Route::get('profile', 'API\ProfileController@getUserProfile');
    Route::put('profile', 'API\ProfileController@updateUserProfile');

    // change password
    Route::post('change-password', 'API\ChangePasswordController@store');

    //formulario vendas
    Route::apiResource('formulario-vendas', 'API\FormularioVendasController');

});
