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

    Route::group(['middleware' => ['auth']], function() {
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');

        Route::get('/logistics', 'LogisticController@index')->name('logistics.index');
    });

    Route::group(['middleware' => ['auth', 'check.admin.status']], function() {
        Route::get('/logistics/create', 'LogisticController@create')->name('logistics.create');
        Route::post('/logistics', 'LogisticController@store')->name('logistics.store');
        Route::get('/logistics/{logistic}/edit', 'LogisticController@edit')->name('logistics.edit');
        Route::put('/logistics/{logistic}', 'LogisticController@update')->name('logistics.update');
        Route::delete('/logistics/{logistic}', 'LogisticController@destroy')->name('logistics.destroy');

        Route::get('/admin/users', 'AdminController@index')->name('admin.users.index');
        Route::post('/admin/users/{user}/toggle-status', 'AdminController@toggleStatus')->name('admin.users.toggle-status');
        Route::put('/admin/users/{user}/update-chatbot-whatsapp-count', 'AdminController@updateChatbotWhatsappCount')->name('admin.users.update-chatbot-whatsapp-count');
    });

    Route::group(['middleware' => ['auth', 'check.non_admin']], function() {
        Route::get('/chatbots', 'ChatbotWhatsappController@index')->name('chatbots.index');
        Route::get('/chatbots/create', 'ChatbotWhatsappController@create')->name('chatbots.create');
        Route::post('/chatbots', 'ChatbotWhatsappController@store')->name('chatbots.store');
        Route::get('/chatbots/{chatbot}/edit', 'ChatbotWhatsappController@edit')->name('chatbots.edit');
        Route::put('/chatbots/{chatbot}', 'ChatbotWhatsappController@update')->name('chatbots.update');
        Route::delete('/chatbots/{chatbot}', 'ChatbotWhatsappController@destroy')->name('chatbots.destroy');
        Route::get('/chatbots/{id}/show-qr', 'ChatbotWhatsappController@showQr')->name('chatbots.show-qrcode'); 
        Route::get('/chatbots/check-all-status', 'ChatbotWhatsappController@checkAllStatus')->name('chatbots.check-all-status');

        Route::get('/customers', 'CustomerController@index')->name('customers.index');
        Route::get('/customers/create', 'CustomerController@create')->name('customers.create');
        Route::post('/customers', 'CustomerController@store')->name('customers.store');
        Route::get('/customers/{customer}/edit', 'CustomerController@edit')->name('customers.edit');
        Route::put('/customers/{customer}', 'CustomerController@update')->name('customers.update');
        Route::delete('/customers/{customer}', 'CustomerController@destroy')->name('customers.destroy');

        Route::get('/chatbot-schedules', 'ChatbotScheduleController@index')->name('chatbot-schedules.index');
        Route::put('/chatbot-schedules/{chatbotSchedule}', 'ChatbotScheduleController@update')->name('chatbot-schedules.update');

        Route::get('/awbs', 'AwbController@index')->name('awbs.index');
        Route::get('/awbs/create', 'AwbController@create')->name('awbs.create');
        Route::post('/awbs', 'AwbController@store')->name('awbs.store');
        Route::get('/awbs/{awb}/edit', 'AwbController@edit')->name('awbs.edit');
        Route::put('/awbs/{awb}', 'AwbController@update')->name('awbs.update');
        Route::delete('/awbs/{awb}', 'AwbController@destroy')->name('awbs.destroy');
    });
});
