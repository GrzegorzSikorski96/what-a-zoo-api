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
        Route::get('/zoos/visited', 'UserController@loggedUserVisitedZoos');
        Route::post('/visit/zoo', 'ZooController@visit');

        Route::delete('/review/remove', 'ReviewController@remove')->middleware('reviewAuthor');
        Route::post('/review/report', 'ReportController@create');
        Route::put('/zoo/editReview', 'ReviewController@edit')->middleware('reviewAuthor');

        Route::get('/users', 'UserController@users');
        Route::get('/user/{userId}', 'UserController@user');

        Route::get('/news', 'FeedController@loggedUserFeed');

        Route::get('/friends', 'FriendController@friends');
        Route::post('/friend/add', 'FriendController@sendFriendRequest');
        Route::post('/friend/accept', 'FriendController@acceptFriendRequest');
        Route::post('/friend/reject', 'FriendController@rejectFriendRequest');
        Route::delete('/friend/remove', 'FriendController@removeFriend');

        Route::group(
            [
                'middleware' => 'friends',
            ],
            function (): void {
                Route::get('/user/{userId}/news', 'FeedController@userFeed');
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

                Route::get('/reports', 'ReportController@reports');
                Route::post('/report/resolve', 'ReportController@resolve');
                Route::get('/report/{id}', 'ReportController@report');
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
});
