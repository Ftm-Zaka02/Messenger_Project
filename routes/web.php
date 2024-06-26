<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Messenger\ChatController;
use App\Http\Controllers\Messenger\ContactController;
use App\Http\Controllers\Messenger\MessageController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


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
Route::middleware('auth')->get('/', function () {
    return view('messenger.index');
})->name('chat');

Route::get('/loginPage', function () {
    return view('messenger.login');
})->name('loginPage');

Route::middleware('auth')->get('/profile/get', function () {
    return response(auth::user(),200);
});

Route::group([
    'middleware' => 'throttle:3,1',
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/signup', [AuthController::class, 'signUp']);
});

Route::group([
    'middleware' => ['throttle:messenger','auth'],
    'prefix' => '/messages'
], function () {
    Route::post('/set', [MessageController::class, 'set']);
    Route::get('/update', [MessageController::class, 'update']);
    Route::get('/delete', [MessageController::class, 'delete']);
    Route::post('/uploadFile', [MessageController::class, 'uploadFile']);
    Route::get('/get', [MessageController::class, 'get']);
});

Route::group([
    'middleware' => ['throttle:messenger','auth'],
    'prefix' => '/contacts'
], function () {
    Route::post('/set', [ContactController::class, 'set']);
    Route::get('/delete', [ContactController::class, 'delete']);
    Route::post('/update', [ContactController::class, 'update']);
});

Route::group([
    'middleware' => ['throttle:messenger','auth'],
    'prefix' => '/chats'
], function () {
    Route::get('/get', [ChatController::class, 'get']);
    Route::post('/search', [ChatController::class, 'search']);
});



