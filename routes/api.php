<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StudentController;

use App\Http\Controllers\StudentAuthController;

use App\Http\Controllers\userAuthController;

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


Route::post('/loginuser', [userAuthController::class, 'userLogin']);


Route::post('/addstudent', [StudentController::class, 'savestudent']);

Route::post('/loginvalidation', [StudentAuthController::class,'login'])->name('login');


Route::post('/refresh-token', [userAuthController::class, 'refreshToken']);


 
//This is API Middleware

// Route::middleware(['studentAuth'])->group (function () {

//     Route::get('/dashboard',[StudentController::class,'dashboard'])->name('dashboard');

//     Route::delete('/deletestudent/{id}', [StudentController::class, 'destroy']);




//     Route::post('/enroll',[EnrollmentController::class,'enroll'])->name('enroll');

// });




// This is JWT Middleware


// Route::middleware(['jwt'])->group (function () {

//       Route::get('/dashboard',[StudentController::class,'dashboard'])->name('dashboard');

//     Route::delete('/deletestudent/{id}', [StudentController::class, 'destroy']);




//     Route::post('/enroll',[EnrollmentController::class,'enroll'])->name('enroll');

// });  //this is only JWT based middleware



Route::middleware(['jwt'])->group (function () {


    Route::middleware(['role:admin'])->group (function () {

          Route::delete('/deletestudent/{id}', [StudentController::class, 'destroy']);

          Route::post('/enroll',[EnrollmentController::class,'enroll'])->name('enroll');


    });


    Route::middleware(['role:user'])-> group (function () {

          Route::get('/dashboard',[StudentController::class,'dashboard'])->name('dashboard');

    });

});  // This is JWT with Role Based middleware