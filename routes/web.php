<?php

use Illuminate\Support\Facades\Route;

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
Route::group(['middleware' => 'language'], function () {

  Route::get('/', function () {
    return view('welcome');
  })->name('home');

  Route::get('/onkentes-regisztracio', 'FrontIndexController@volunteer_form')->name('onkentes-regisztracio');
  Route::get('/segitseg-keres', 'FrontIndexController@helprequest_form')->name('segitseg-keres');
  Route::post('/postcode-autocomplete', 'FrontIndexController@post_code_ajax')->name('post_code_autocomplete');
  Route::post('/form-submit', 'FrontIndexController@register');

  Route::group(['prefix' => 'administration'], function () {
    Voyager::routes();
  });

  Auth::routes(['verify' => true]);

  Route::middleware(['verified'])->group(function () {
    Route::group(['prefix' => 'admin'], function () {
      Route::get('/', 'DashboardController@index')->name('admin_home');
      Route::get('/sajat-segitsegkeresek', 'DashboardController@own_help_request_list')->name('admin_own_help_request');
      Route::get('/leadott-segitsegkeresek', 'DashboardController@my_help_request_list')->name('admin_my_help_request');
      Route::get('/nyitott-segitsegkeresek', 'DashboardController@open_help_request_list')->name('admin_open_help_request');
      Route::get('/uj-segitsegkeres', 'DashboardController@new_help_request')->name('admin_new_help_request');
      Route::get('/vigyazok', 'DashboardController@volunteers_list')->name('admin_volunteers_list');
      Route::get('/profile', 'DashboardController@profile')->name('admin_profile');

      Route::post('/profile', 'DashboardController@save_profile')->name('admin_save_profile');
      Route::post('/save_support_data', 'DashboardController@save_support_data')->name('admin_save_support_data');
      Route::post('/volunteer_for_support_ajax', 'DashboardController@volunteer_for_support_ajax')->name('volunteer_for_support_ajax');
      Route::post('/get_more_user_details_ajax', 'DashboardController@get_more_user_details_ajax')->name('get_more_user_details_ajax');
      Route::post('/send_volunteer_notification_ajax', 'DashboardController@send_volunteer_notification_ajax')->name('send_volunteer_notification_ajax');
    });
  });

  Route::get('/jogi_nyilatkozat', 'LegalController@legal_text')->name('legal');
  Route::get('/adatvedelmi_nyilatkozat', 'LegalController@privacy_text')->name('privacy');
  Route::get('/cookie_hasznalati_szabalyzat', 'LegalController@cookie_text')->name('cookie');
  Route::get('/hibabejelentes', 'ErrorController@index')->name('error_reporting');
  Route::post('/hiba_bekuldes', 'ErrorController@submit')->name('error_sending');

});

// Phone verification routes // TODO probably shoud throttle requests
Route::name('phoneverify.send')
    ->post('/phoneverification', 'PhoneVerificationController@sendCode');

Route::name('phoneverify.check')
     ->post('/phoneverification/check', 'PhoneVerificationController@checkCode');
