<?php


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




Route::group(['prefix' => 'v1'], function(){
    Route::post('player-login', 'ApiController@login');
    Route::post('social-login', 'Auth\ApiAuthController@apiSocialLogin');
    Route::group(['middleware'=>'auth:api'], function () {
        Route::get('input/phone/verify', 'FrontController@phoneVerifyInput'); //perfect
        Route::post('phone/submit', 'ApiController@profileAttachWIthPhone'); //perfect
        Route::get('futsals', 'Api\ApiFutsalController@index'); //perfect
        Route::post('futsal/{futsal}/favourite', 'Api\ApiFutsalController@favouriteMaker'); //perfect
        Route::get('futsal/{futsal}', 'Api\ApiFutsalController@futsal'); //perfect
        Route::get('my-bookings', 'Api\ApiBookingController@userBookings'); //perfect
        Route::post('futsal/{futsal}/book', 'Api\ApiBookingController@store'); //perfect
        Route::get('futsal/{futsal}/bookings', 'Api\ApiBookingController@index');//perfect
    });
});