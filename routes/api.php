<?php

use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\Member\RegistrationController;
use App\Http\Controllers\Admin\SubdivisionController;
use App\Http\Controllers\AuthController;
use App\Models\Subdivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::group(['prefix' => 'admin', 'middleware' => 'hoa_admin'], function () {
        Route::apiResource('/member', RegistrationController::class);
        Route::put('/member/change/status/{id}', [RegistrationController::class, 'change_status']);
        Route::apiResource('/user',UsersController::class)->except('create');
        Route::get('/user/show/email',[UsersController::class,'show_email']);
        Route::get('/user/show/subdivision',[UsersController::class,'show_subdivision']);
        Route::put('/user/change/status/{id}', [UsersController::class, 'change_status']);
        Route::apiResource('/subdivision',SubdivisionController::class);
        Route::get('/subdivision/show/email',[SubdivisionController::class,'show_email']);
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
