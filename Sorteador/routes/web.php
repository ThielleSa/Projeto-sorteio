<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstagramController;

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
    return redirect('/login');
});

Route::get('/login', function(){
    return view('login');
});

Route::post('/authenticating', [InstagramController::class, 'logar'])->name('logar');
Route::get('/posts', [InstagramController::class, 'index'])->name('index');
Route::get('/posts/{mediaId}', [InstagramController::class, 'show']);
Route::post('/raffle', [InstagramController::class, 'raffleComments']);

Route::post('/logout', [InstagramController::class, 'logout'])->name('logout');

Route::get('/user-manager', [InstagramController::class, 'userManager'])->name('user-manager');



