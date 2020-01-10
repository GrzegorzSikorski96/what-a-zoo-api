<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'middleware' => 'api',
    ],
    function (): void {
        Route::get('/', 'ExceptionController@getEmptyResponse');
        Route::get('/test', 'TestController@test');
        Route::post('/register', 'Auth\RegisterController@register');
    }
);

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router): void {
    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');
    Route::post('/refresh', 'AuthController@refresh');
    Route::post('/me', 'AuthController@me');
});
