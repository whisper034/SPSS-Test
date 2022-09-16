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

Route::permanentRedirect('/home', '/')->name('home');
Route::get('/', 'HomeController@index');
Route::get('/about', 'HomeController@about');
Route::get('/seminar', 'HomeController@seminar');
Route::get('/lomba', 'HomeController@lomba');

Auth::routes(['verify' => 'true']);

Route::get('/password/change', 'Auth\ChangePasswordController@index');
Route::post('/password/change', 'Auth\ChangePasswordController@change')->name('change-password');

Route::get('/dashboard', 'Peserta\DashboardController@index')->name('dashboard');
Route::get('/dashboard/download', 'FileController@downloadLomba')->name('dashboard-download');
Route::get('/dashboard/answer', 'Peserta\LombaController@downloadAnswer')->name('answer-download');
Route::post('/dashboard/submit', 'Peserta\LombaController@submit')->name('submit-answer');
Route::post('/dashboard/finalise', 'Peserta\LombaController@finalise')->name('finalise-answer');

Route::get('/pembayaran', 'Peserta\RegistrasiLombaController@showFormPembayaran');
Route::post('/pembayaran', 'Peserta\RegistrasiLombaController@submitPembayaran')->name('pembayaran');
Route::get('/pembayaran/resubmit', 'Peserta\RegistrasiLombaController@resubmitPembayaran')->name('resubmit-pembayaran');

Route::get('/data-peserta', 'Peserta\RegistrasiLombaController@showFormDataPeserta');
Route::post('/data-peserta', 'Peserta\RegistrasiLombaController@submitDataPeserta')->name('data-peserta');

Route::get('/download', 'FileController@downloadUmum')->name('general-download');