<?php

use App\Http\Controllers\MainController;
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

Route::get('/', [MainController::class, 'index']);

Route::get('/about', function () {
    return view('main.about');
});

Route::get('/contact', function () {
    $array  = [
        'name' => 'Rus',
        'adress' => 'Pryaniki',
        'email' => '..@mos.ru',
        'phone' => '8 800 555 35 35'
    ];
    return view('main.contact', ['contact' => $array]);
});

Route::get('/full_img/{img}', [MainController::class, 'show']);