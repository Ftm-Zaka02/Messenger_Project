<?php

use App\Http\Controllers\MessageController;
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
    return view('messenger.index');
});

Route::prefix('messages')->group(function () {
    Route::post('/set', [MessageController::class, 'set']);
    Route::get('/get', [MessageController::class, 'get']);
    Route::get('/update', [MessageController::class, 'update']);
    Route::get('/delete', [MessageController::class, 'delete']);
});




