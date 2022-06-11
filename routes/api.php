<?php

use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\DirectorController;
use App\Http\Controllers\Admin\DueController;
use App\Http\Controllers\Admin\Member\AnnouncementController;
use App\Http\Controllers\Admin\Member\AutogateController;
use App\Http\Controllers\Admin\Member\CardController;
use App\Http\Controllers\Admin\Member\DocumentController;
use App\Http\Controllers\Admin\Member\TemplateController;
use App\Http\Controllers\Admin\Member\TransactionController;
use App\Http\Controllers\Admin\PrivilegeController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\Member\RegistrationController;
use App\Http\Controllers\Admin\SubdivisionController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\Member\LotController;



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

    //hoa admin routes
    Route::group(['prefix' => 'admin', 'middleware' => 'hoa_admin'], function () {

        //member routes
        Route::apiResource('/member', RegistrationController::class);
        Route::put('/member/change/status/{id}', [RegistrationController::class, 'change_status']);
        Route::get('/member/search/data',[RegistrationController::class,'search_member']);

        //user management routes
        Route::apiResource('/user',UsersController::class)->except('create');
        Route::get('/user/show/email',[UsersController::class,'show_email']);
        Route::get('/user/show/subdivision',[UsersController::class,'show_subdivision']);
        Route::put('/user/change/status/{id}', [UsersController::class, 'change_status']);

        //subdivision routes
        Route::apiResource('/subdivision',SubdivisionController::class);
        Route::get('/subdivision/search/data',[SubdivisionController::class,'search_subdivision']);
        Route::put('/subdivision/change/status/{id}', [SubdivisionController::class, 'change_status']);
        Route::get('/subdivision/search/user/', [SubdivisionController::class, 'search_user']);
        Route::get('/subdivision/show/email',[SubdivisionController::class,'show_email']);

        //privilege routes
        Route::apiResource('/privilege',PrivilegeController::class);
        Route::put('/privilege/change/status/{id}', [PrivilegeController::class, 'change_status']);
        Route::get('/privilege/search/data',[PrivilegeController::class,'search_privilege']);

        //agent routes
        Route::apiResource('/agent',AgentController::class);
        Route::put('/agent/change/status/{id}', [AgentController::class, 'change_status']);
        Route::get('/agent/search/data',[AgentController::class,'search_agent']);

        //directors routes
        Route::get('/directors/{id}/subdivision',[DirectorController::class,'index']);
        Route::apiResource('/directors',DirectorController::class)->except('index');
        Route::get('/directors/search/user/', [SubdivisionController::class, 'search_user']);
        Route::get('/directors/show/user/{id}',[DirectorController::class,'show_user']);

        //due routes
        Route::get('/due/{id}/subdivision',[DueController::class,'index']);
        Route::apiResource('/due',DueController::class)->except('index');
        Route::get('/due/show/schedule/{id}',[DueController::class,'show_schedule']);

        //lot routes
        Route::get('/lot/{id}/member',[LotController::class,'index']);
        Route::apiResource('/lot',LotController::class)->except('index');
        Route::get('/lot/show/subdivision',[LotController::class,'show_subdivision']);
        Route::get('/lot/show/agent',[LotController::class,'show_agent']);
        Route::get('/lot/search/subdivision',[LotController::class,'search_subdivision']);

        //password_reset
        Route::post('forget-password',[RegistrationController::class,'submit_forget_password_form']);

        //member documents routes
        Route::get('/document/{id}/member',[DocumentController::class,'index']);
        Route::apiResource('document',DocumentController::class);
        Route::delete('/file/{id}',[DocumentController::class,'deleteFile']);



        //announcement routes
        Route::apiResource('/announcement',AnnouncementController::class);
        Route::get('/announcement/fullstory/{id}',[AnnouncementController::class,'showStory']);
        Route::put('/announcement/updateStory/{id}',[AnnouncementController::class,'updateStory']);

        //rfid routes
        Route::apiResource('/rfid',CardController::class);
        Route::get('/rfid/search/data',[CardController::class,'search_rfid']);

        //privilege transaction
        Route::get('/transaction/{id}/rfid',[TransactionController::class,'index']);
        Route::apiResource('/transaction',TransactionController::class)->only('delete','store');

        //autogate
        Route::apiResource('/autogate',AutogateController::class);
        Route::get('/autogate/search/data',[AutogateController::class,'search_autogate']);
        Route::get('/autogate/templates/data',[AutogateController::class,'template']);
        Route::get('/autogate/user/subdivision',[AutogateController::class,'user_subdivision']);

        //autogate template
        Route::apiResource('/template',TemplateController::class);
    });



    Route::post('/logout', [AuthController::class, 'logout']);
});


Route::post('/reset-password', [RegistrationController::class,'submit_reset_password_form']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
