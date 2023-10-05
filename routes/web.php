<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FirebaseController;
use Illuminate\Http\Request;
use Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// routes/web.php

Route::get('/otp', 'RegisterController@index')->name('otp');
Route::post('/validate-phone', 'Auth\RegisterController@validatePhoneNumber')->name('validate.phone');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/profile', 'UserController@profile')->name('profile');
Route::post('/profile', 'UserController@store')->name('profile-save');
Route::post('/pic', 'UserController@pic')->name('pic-save');
Route::post('/password-update', 'UserController@pass_update')->name('pass-save');
Route::get('/update-online-status', 'UserController@updateOnlineStatus')->name('updateonlinestatus');
Route::post('/get-user-suggestions', 'UserController@getUserSuggestions')->name('get-user-suggestions');

Route::get('/check-online-status/{userId}', 'UserController@checkOnlineStatus');


Route::post('/store-chat', 'ChatController@storechat')->name('store-chat');
Route::post('/chat', 'ChatController@store')->name('chat');
Route::get('/chat-list', 'ChatController@chat_list')->name('chat_list');
Route::get('/chat-update', 'ChatController@chat_update')->name('chat_update');

Route::post('/message', 'MsgController@store')->name('message');
Route::post('/message-list', 'MsgController@message_list')->name('message_list');
Route::post('/new-message-list', 'MsgController@new_message_list')->name('new_message_list');
Route::post('/message-seen', 'MsgController@message_seen')->name('message_seen');
Route::get('/check-seen-updates', 'MsgController@checkSeenUpdates')->name('checkSeenUpdates');;





Route::post('/active', 'ActiveChatController@store')->name('store');
Route::post('/set-active', 'ActiveChatController@set_active')->name('set_active');
Route::post('/check-active', 'ActiveChatController@check_active')->name('check_active');



Route::post('/forgot_password', 'Auth\ForgotPasswordController@password')->name('forgot_password');
Route::get('/reset_password/{email}/{token}', 'Auth\ForgotPasswordController@showResetForm')->name('password.request');

/*Route::post('/reset_password', 'Auth\ForgotPasswordController@resetPassword')->name('password.update');*/
Route::post('/password/reset/success', 'Auth\ForgotPasswordController@showResetSuccess')->name('password.reset.success');


