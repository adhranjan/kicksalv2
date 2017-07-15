<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/




Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::group(['middleware' => ['auth']], function() { // only login goes here
    Route::group(['prefix' => 'developer', 'middleware' => ['role:developer']], function() {// developers url goes here
        Route::get('/', ['as' => 'developers_home','uses'=>'DeveloperController@index']);


    });

    Route::group(['prefix' => 'kicksal', 'middleware' => ['role:kicksal_owners|kicksal_staffs']], function() {// all app teams url goes here
        Route::get('/', ['as' => 'kicksal_home','uses'=>'StaffController@index']);
        Route::group(['middleware' => ['permission:manage-futsal']], function() {// people who can manage futsal
            Route::resource('futsal', 'FutsalController');
        });

    });

    Route::group(['prefix' => 'grounds', 'middleware' => ['role:futsal_admin|futsal_owners|futsal_staffs']], function() {// all ground owners url goes here
        Route::get('/', ['as' => 'futsal_home','uses'=>'GroundController@index']);
        Route::group(['middleware' => ['permission:manage-my-futsal']], function() {// people who can manage futsal
            Route::get('/create_my_user', ['as' => 'create_my_user','uses'=>'GroundController@createMyUser']);
            Route::post('/create_my_user', ['as' => 'create_my_user_post','uses'=>'GroundController@createMyUserPost']);
            Route::get('/my_futsal_users', ['as' => 'my_futsal_users','uses'=>'GroundController@userLists']);
            Route::get('/user/{id}/edit', ['as' => 'my_user_edit','uses'=>'GroundController@userEdit']);
            Route::put('/user/{id}/edit', ['as' => 'my_user_edit_post','uses'=>'GroundController@userEditPost']);



        });





    });

    Route::group(['prefix' => 'kick', 'middleware' => ['role:users']], function() {// all users url goes here i.e. Players
        Route::get('/', ['as' => 'users_home','uses'=>'GroundController@index']);

    });


});


Route::get('/', 'HomeController@index')->name('home');
