<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlShortenerController;

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

Route::get('/', [UrlShortenerController::class, 'index'])
    ->name('url-shortener.index');

Route::post('/shorten-url', [UrlShortenerController::class, 'shorten'])
    ->name('url-shortener.shorten');

Route::get('/{shortened_url:path}', [UrlShortenerController::class, 'redirect'])
    ->name('url-shortener.redirect');
