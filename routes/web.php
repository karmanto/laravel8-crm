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

Route::group(['namespace' => 'App\Http\Controllers'], function()
{   
    Route::get('/', 'HomeController@index')->name('home.index');

    Route::group(['middleware' => ['guest']], function() {
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');

    });

    Route::group(['middleware' => ['auth', 'check.admin.status']], function() {
        Route::get('/admin/users', 'AdminController@index')->name('admin.users.index');
        Route::post('/admin/users/{user}/toggle-status', 'AdminController@toggleStatus')->name('admin.users.toggle-status');
    });

    Route::group(['middleware' => ['auth']], function() {
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
        Route::get('/chatbots', 'ChatbotWhatsappController@index')->name('chatbots.index');
        Route::get('/chatbots/create', 'ChatbotWhatsappController@create')->name('chatbots.create');
        Route::post('/chatbots', 'ChatbotWhatsappController@store')->name('chatbots.store');
        Route::get('/chatbots/{chatbot}/edit', 'ChatbotWhatsappController@edit')->name('chatbots.edit');
        Route::put('/chatbots/{chatbot}', 'ChatbotWhatsappController@update')->name('chatbots.update');
        Route::delete('/chatbots/{chatbot}', 'ChatbotWhatsappController@destroy')->name('chatbots.destroy');
        Route::get('/chatbots/{id}/show-qr', 'ChatbotWhatsappController@showQr')->name('chatbots.show-qrcode'); 
        Route::get('/chatbots/check-all-status', 'ChatbotWhatsappController@checkAllStatus')->name('chatbots.check-all-status');
    });
});
