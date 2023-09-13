<?php

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\VerifyEmailController;
use App\Http\Controllers\API\EmailverificationController;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\ProductsController;

use App\Http\Controllers\API\ForgetPasswordController;
use App\Http\Controllers\API\ResetPasswordController;





// use App\Http\Controllers\API\ProductController;

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


Route::controller(RegisterController::class)->group(function(){
    Route::post('register', 'register'); //normal register
    Route::post('registerverifiction','registerverrfication');//register with sendiing code
    Route::post('login', 'login');//log in using email
    Route::post('loginphone', 'loginphone');//login using phone number
    Route::post('logout','logout');
});


Route::post('password/forgot-password',[App\Http\Controllers\API\ForgetPasswordController::class,'forgotPassword']);
Route::post('password/reset',[App\Http\Controllers\API\ResetPasswordController::class,'passwordReset']);




Route::middleware('auth:sanctum')->group( function () {

    Route::post('email_verification',[App\Http\Controllers\API\EmailverificationController::class,'email_verification']);
    Route::get('email_verification_2',[App\Http\Controllers\API\EmailverificationController::class,'sendEmailVerification']);



});

// Route::resource('product', ProductController::class);

// Route::resource('user',[App\Http\Controllers\API\UserController::class]);
Route::resource('product',ProductsController::class);
Route::resource('user',UserController::class);


// Route::resource('product', [App\Http\Controllers\API\ProductsController::class]);

// Route::get('producttest',[App\Http\Controllers\API\ProductsController::class,'index']);
Route::post('assign_product',[App\Http\Controllers\API\ProductsController::class,'assign_product']);

Route::get('get_user_products/{id}',[App\Http\Controllers\API\ProductsController::class,'get_user_products']);


// Route::middleware('Admin')->group( function () {




// });

// Route::middleware('Emailverification')->group( function () {
//     Route::get('test_for_middlewar_emailverify',[App\Http\Controllers\API\UserController::class,'testformiddleware']);


// });

