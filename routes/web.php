<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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

Auth::routes(['verify' => true ]);
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware(['auth'])->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');



Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/users', [App\Http\Controllers\HomeController::class, 'users'])->name('users');
Route::post('/update/role', [App\Http\Controllers\HomeController::class, 'updateRole'])->name('update.role');


/*
/ File manipulation Routes
/ @info: Middleware specific definitions are inside construct of FileController::class
*/

Route::group([

    'middleware' => ['auth', 'verified'],
    'prefix' => 'file'

], function ($router) {

  Route::get('/upload', [App\Http\Controllers\FileController::class, 'uploadForm'])->name('uploadForm');
  Route::post('/upload', [App\Http\Controllers\FileController::class, 'upload'])->name('upload');

  Route::get('/list', [App\Http\Controllers\FileController::class, 'listFiles'])->name('list.files');
  Route::post('/delete', [App\Http\Controllers\FileController::class, 'deleteFile'])->name('delete.file');
  Route::post('/parse', [App\Http\Controllers\FileController::class, 'parseFile'])->name('parse.file');

});



/*
/ Knjiga specific routes
/ @info: Middleware specific definitions are inside construct of FileController::class
*/

Route::group([

    'middleware' => ['auth', 'verified'],
    'prefix' => 'knjiga'

], function ($router) {

  Route::get('/', [App\Http\Controllers\KnjigeController::class, 'index'])->name('index.knjiga');

});



/* FALL BACK ROUTE */
Route::fallback(function () {
    abort(404);
});
