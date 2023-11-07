<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::name('home.')
    ->controller(HomeController::class)
    ->group(function () {
        Route::get('/', function () {
            return redirect()->route('home.index');
        });
        Route::get('/home', 'index')->name('index');
        Route::get('/donate', 'donate')->name('donate');
    });

Route::name('stripe.')
    ->controller(PaymentController::class)
    ->prefix('stripe')
    ->group(function () {
        Route::get('/payment', 'index')->name('index');
        Route::post('/payment', 'store')->name('store');
    });

