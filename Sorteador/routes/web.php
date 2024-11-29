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

Route::get('/', function () {
    return redirect('/posts');
});

use App\Http\Controllers\InstagramController;

Route::get('/posts', [InstagramController::class, 'index']);
Route::get('/posts/{mediaId}', [InstagramController::class, 'show']);
Route::post('/raffle', [InstagramController::class, 'raffleComments']);



