<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FatoorahController;
use App\Http\Controllers\UserController;

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

Route::group(['middleware'=>'auth:sanctum'] , function () {
    Route::controller(FatoorahController::class)->group(function() {

    Route::post('/pay' , 'payOrder');
});
});

Route::get('call_back' , [FatoorahController::class , 'paymentCallBack'])->name('success');

Route::get('/error' , function(){
    return 'payment failed';
})->name('error');

Route::post('/login' , [UserController::class , 'login'])->name('user.login');
Route::post('/register' , [UserController::class , 'register'])->name('user.register');
