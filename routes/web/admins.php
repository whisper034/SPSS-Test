<?php

use Illuminate\Support\Facades\Route;

Route::get('/login', 'Admin\LoginController@showLoginForm')->name('admin-login');
Route::post('/login', 'Admin\LoginController@login');
Route::post('/logout', 'Admin\LoginController@logout')->name('admin-logout');

Route::get('/', 'Admin\DashboardController@index');

Route::get('/peserta', 'Admin\PesertaController@index');
Route::post('/peserta', 'Admin\PesertaController@detail');
Route::get('/peserta/{peserta_id}/payment', 'Admin\PesertaController@paymentPhoto')->name('payment-photo');
Route::post('/peserta/payment', 'Admin\PesertaController@verifyPayment')->name('verify-payment');
Route::get('/peserta/{peserta_id}/ktm', 'Admin\PesertaController@downloadKtm')->name('download-ktm');

Route::get('/lomba', 'Admin\LombaController@index');
Route::get('/lomba/{tahap_id}', 'Admin\LombaController@loadTable')->name('load-table-lomba');
Route::get('/lomba/{tahap_id}/data', 'Admin\LombaController@dataLomba')->name('get-data-lomba');
Route::get('/lomba/{tahap_id}/download', 'Admin\LombaController@download')->name('download-data-lomba');
Route::post('/lomba/{tahap_id}', 'Admin\LombaController@nextPhase')->name('next-phase');

Route::get('/timeline/reset', 'Admin\TimelineController@reset');
Route::get('/timeline/{id?}', 'Admin\TimelineController@index');
Route::post('/timeline', 'Admin\TimelineController@update')->name('update-timeline');

Route::get('/profile', 'Admin\ProfileController@index');
Route::post('/profile', 'Admin\ProfileController@update')->name('update-admin-profile');
Route::post('/profile/password', 'Admin\ProfileController@changePassword')->name('admin-change-password');

Route::get('/notification', 'Admin\NotificationController@index');
Route::get('/notification/redirect', 'Admin\NotificationController@redirect')->name('notification-redirect');

Route::get('/user/{id?}', 'Admin\UserController@index');
Route::post('/user', 'Admin\UserController@store')->name('store-admin');
Route::post('/user/delete', 'Admin\UserController@delete')->name('delete-admin');