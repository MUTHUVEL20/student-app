<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController;

use App\Http\Controllers\StudentAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/addstudent', [StudentController::class, 'savestudent']);

Route::post('/login', [studentAuthController::class,'login'])->name('login');

Route::middleware(['studentAuth'])->group (function () {

    Route::get('/dashboard',[StudentController::class,'dashboard'])->name('dashboard');



    Route::post('/enroll',[EnrollmentController::class,'enroll'])->name('enroll');

});