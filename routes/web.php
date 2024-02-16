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
    return view('welcome');
});

Route::prefix('messages')->group(function () {
    Route::get('/set/{text}/{chat}', [MessageController::class, 'set'])->where('text', '[A-Za-z]+')->whereIn('chat_name', ['farawin', 'Go Channel']);
    Route::get('/get/{uploaded?}', [MessageController::class, 'get']);
    Route::get('/update/{dataId}/{newMessage}', [MessageController::class, 'update']);
    Route::get('/delete/{deleteId}/{deleteType}', [MessageController::class, 'delete'])->whereIn('deleteType', ['integrated', 'physicalDelete', 'softDelete']);
});




