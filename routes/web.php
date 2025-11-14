<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentAuthController;

use App\Http\Controllers\StudentController;

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


Route::get('/login', [studentAuthController::class, 'loginPage'])->name('login.page');

Route::post('/login', [studentAuthController::class,'login'])->name('login');

Route::get('/logout',[studentAuthController::class,'logout'])->name('logout');

    Route::post('/addstudent',[StudentController::class,'savestudent']);


Route::middleware(['studentAuth'])->group (function () {

    Route::get('/dashboard',[StudentController::class,'dashboard'])->name('dashboard');



    Route::post('/enroll',[EnrollmentController::class,'enroll'])->name('enroll');

});