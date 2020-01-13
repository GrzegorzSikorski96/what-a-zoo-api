<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

Route::group(
    [
        'middleware' => 'api',
    ],
    function (): void {
        Route::get('/', 'ExceptionController@getEmptyResponse');
        Route::post('/register', 'Auth\RegisterController@register');
    }
);


Route::group(
    [
        'middleware' => ['auth', 'api']
    ],
    function (): void {
        Route::get('/zoos', 'ZooController@zoos');
        Route::get('/zoo/{zooId}', 'ZooController@zooWithReviews');


        Route::post('/visit/zoo', 'ZooController@visit');

        Route::get('/zoos/visited', 'UserController@loggedUserVisitedZoos');
        Route::get('/users', 'UserController@users');
        Route::get('/user/{userId}', 'UserController@user');

        Route::group(
            [
                'middleware' => 'friends',
            ],
            function (): void {
                Route::get('/user/{userId}/visited', 'UserController@visitedById');
            }
        );

        Route::group(
            [
                'middleware' => 'visitedZoo',
            ],
            function (): void {
                Route::post('/unvisit/zoo', 'ZooController@unvisit');
                Route::post('/zoo/addReview', 'ReviewController@create')->middleware('alreadyReviewed');
                Route::put('/zoo/editReview', 'ReviewController@edit')->middleware('reviewAuthor');
                Route::delete('/zoo/editReview', 'ReviewController@edit')->middleware('reviewAuthor');
            }
        );

        Route::group(
            [
                'middleware' => 'role.administrator',
            ],
            function (): void {
                Route::post('/user/{userId}/ban', 'UserController@ban');
                Route::post('/user/{userId}/unban', 'UserController@unban');
                Route::post('/zoo/add', 'ZooController@create');
                Route::delete('/zoo/remove', 'ZooController@remove');
            }
        );
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
