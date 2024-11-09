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

        Route::get('/customerAdders', 'CustomerAdderController@index')->name('customerAdders.index');
        Route::get('/customerAdders/create', 'CustomerAdderController@create')->name('customerAdders.create');
        Route::post('/customerAdders', 'CustomerAdderController@store')->name('customerAdders.store');
        Route::get('/customerAdders/{customerAdder}/edit', 'CustomerAdderController@edit')->name('customerAdders.edit');
        Route::put('/customerAdders/{customerAdder}', 'CustomerAdderController@update')->name('customerAdders.update');
        Route::delete('/customerAdders/{customerAdder}', 'CustomerAdderController@destroy')->name('customerAdders.destroy');

        Route::get('/chatbot-schedules', 'ChatbotScheduleController@index')->name('chatbot-schedules.index');
        Route::get('/chatbot-schedules/create', 'ChatbotScheduleController@create')->name('chatbot-schedules.create');
        Route::post('/chatbot-schedules', 'ChatbotScheduleController@store')->name('chatbot-schedules.store');
        Route::get('/chatbot-schedules/{chatbotSchedule}', 'ChatbotScheduleController@show')->name('chatbot-schedules.show');
        Route::get('/chatbot-schedules/{chatbotSchedule}/edit', 'ChatbotScheduleController@edit')->name('chatbot-schedules.edit');
        Route::put('/chatbot-schedules/{chatbotSchedule}', 'ChatbotScheduleController@update')->name('chatbot-schedules.update');
        Route::delete('/chatbot-schedules/{chatbotSchedule}', 'ChatbotScheduleController@destroy')->name('chatbot-schedules.destroy');

        Route::get('/awb-notifiers', 'AwbNotifierController@index')->name('awb-notifiers.index');
        Route::get('/awb-notifiers/create', 'AwbNotifierController@create')->name('awb-notifiers.create');
        Route::post('/awb-notifiers', 'AwbNotifierController@store')->name('awb-notifiers.store');
        Route::get('/awb-notifiers/{awbNotifier}', 'AwbNotifierController@show')->name('awb-notifiers.show');
        Route::get('/awb-notifiers/{awbNotifier}/edit', 'AwbNotifierController@edit')->name('awb-notifiers.edit');
        Route::put('/awb-notifiers/{awbNotifier}', 'AwbNotifierController@update')->name('awb-notifiers.update');
        Route::delete('/awb-notifiers/{awbNotifier}', 'AwbNotifierController@destroy')->name('awb-notifiers.destroy');

        Route::get('/awbAdders', 'AwbAdderController@index')->name('awbAdders.index');
        Route::get('/awbAdders/create', 'AwbAdderController@create')->name('awbAdders.create');
        Route::post('/awbAdders', 'AwbAdderController@store')->name('awbAdders.store');
        Route::get('/awbAdders/{awbAdder}/edit', 'AwbAdderController@edit')->name('awbAdders.edit');
        Route::put('/awbAdders/{awbAdder}', 'AwbAdderController@update')->name('awbAdders.update');
        Route::delete('/awbAdders/{awbAdder}', 'AwbAdderController@destroy')->name('awbAdders.destroy');
    });
});
