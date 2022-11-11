<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('segurados', 'API\SeguradosController');

    // get user profile
    Route::get('profile', 'API\ProfileController@getUserProfile');
    Route::put('profile', 'API\ProfileController@updateUserProfile');
    Route::get('profile/permission', 'API\ProfileController@hasPermission');

    Route::get('findUser', 'API\UserController@search');

    // change password
    Route::post('change-password', 'API\ChangePasswordController@store');


    Route::group(['middleware' => ['can:read users']], function () {
        Route::apiResource('user', 'API\UserController');
        Route::get('getAllRoles', 'API\PermissionUserController@getAllRoles');
        Route::get('permissions', 'API\PermissionUserController@getAllPermissions');
        Route::get('permissions-roles', 'API\PermissionUserController@getAllRolesPermissions');

    });

});
