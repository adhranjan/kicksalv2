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
        Route::resource('staff-profile', 'StaffProfileController');
        Route::get('/player-detail/', ['as' => 'get_player_detail_with_number','uses'=>'BookingController@getPlayerDetail']);
        Route::get('/player-profile/{id}', ['as' => 'get_player_detail_with_id','uses'=>'GroundController@getPlayerProfile']);
        Route::post('/pay-futsal-bill/{player_id}', ['as' => 'futsal_bill','uses'=>'GroundController@futsalBillPayment']);
        Route::resource('my-bookings', 'BookingController');

        Route::group(['middleware' => ['permission:manage-my-futsal']], function() {// people who can manage their futsal
            Route::resource('time-price', 'FutsalPricingController');
            Route::get('/create-my-user', ['as' => 'create_my_user','uses'=>'GroundController@createMyUser']);
            Route::post('/create-my-user', ['as' => 'create_my_user_post','uses'=>'GroundController@createMyUserPost']);
            Route::get('/my-futsal-users', ['as' => 'my_futsal_users','uses'=>'GroundController@userLists']);
            Route::get('/user/{id}/edit', ['as' => 'my_user_edit','uses'=>'GroundController@userEdit']);
            Route::put('/user/{id}/edit', ['as' => 'my_user_edit_post','uses'=>'GroundController@userEditPost']);
            Route::get('/setup-ground', ['as' => 'setup_ground','uses'=>'GroundController@groundSetup']);
            Route::post('/setup-ground', ['as' => 'setup_ground_post','uses'=>'GroundController@groundSetupPost']);
            Route::post('/change-display-pciture', ['as' => 'change_futsal_display_picture','uses'=>'GroundController@displayPictureChangePost']);
            Route::post('/change-futsal-coordinates', ['as' => 'change_futsal_coordinates','uses'=>'GroundController@coordinatesPostChange']);
        });
        Route::group(['middleware' => ['permission:my-futsal-bills']], function() {// billing
            Route::get('/my-futsal-bills', ['as' => 'my_futsal_bills','uses'=>'BillingController@index']);
            Route::get('/my-futsal-bill-summary', ['as' => 'my_futsal_bill_summary','uses'=>'BillingController@summary']);
        });
    });



    Route::group(['prefix' => 'kick', 'middleware' => ['role:player_user']], function() {// all users url goes here i.e. Players
        Route::get('/', ['as' => 'users_home','uses'=>'FrontController@index']);
        Route::get('futsal/{futsal}', ['as' => 'futsal_detail_home','uses'=>'FrontController@futsal']);
        Route::get('search/', ['as' => 'futsal_search','uses'=>'FrontController@search']);



        Route::group(['middleware' =>'doesNotHavePlayerProfile'], function() {//not having profile can go here
            Route::get('input/phone/verify', ['as' => 'input_phone','uses'=>'FrontController@phoneVerifyInput']); //perfect
            Route::post('phone/verify', ['as' => 'player_update_phone','uses'=>'FrontController@profileAttachWIthPhone']); //perfect
            Route::get('phone/verify', ['as' => 'player_verify_phone','uses'=>'FrontController@phoneVerifyGet']); //perfect
        });

        Route::group(['middleware' =>'hasPlayerProfile'], function() {//this needs profile middleware
            Route::post('futsal/{futsal}/book', ['as' => 'futsal_book_home','uses'=>'FrontController@book']);
            Route::post('futsal/{futsal}/favourite', ['as' => 'futsal_fav_home','uses'=>'FrontController@favouriteMaker']); //perfect
            Route::post('change-my-username', ['as' => 'change_my_username','uses'=>'FrontController@chnageMyUserName']); //perfect
            Route::get('my-profile', ['as' => 'player_front_profile','uses'=>'FrontController@kicksalUserProfile']); //perfect
            Route::put('my-profile-dp', ['as' => 'player_front_profile_change_dp','uses'=>'PlayerProfileController@changeDp']); //perfect
        });
    });
});

Route::get('/', 'HomeController@index')->name('home');
Route::get('/{file_id}', ['as' => 'web_image','uses'=>'ImageController@getAvatarImage']);


Route::group(['prefix' => 'social/auth'], function() {
    Route::get('google', ['as' => 'google_login_request','uses'=>'Auth\ApiAuthController@redirectToProvider']);
    Route::get('google/callback', 'Auth\ApiAuthController@handleProviderCallback');
});
