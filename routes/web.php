<?php

use App\Http\Controllers\messenger\MessageController;
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
    session(['userID' => '191']);
    return view('messenger.index');
});
Route::get('/loginPage', function () {
    return view('messenger.login');
});

Route::prefix('messages')->middleware(['throttle:messenger'])->group(function () {
    Route::post('/set', [MessageController::class, 'set']);
    Route::get('/get', [MessageController::class, 'get']);
    Route::get('/update', [MessageController::class, 'update']);
    Route::get('/delete', [MessageController::class, 'delete']);
    Route::post('/uploadFile',[MessageController::class, 'uploadFile']);
});

Route::post('/login',[AuthController::class, 'login']);



