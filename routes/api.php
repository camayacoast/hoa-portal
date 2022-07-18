<?php

use App\Http\Controllers\Admin\AgentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DirectorController;
use App\Http\Controllers\Admin\DueController;
use App\Http\Controllers\Admin\Member\AnnouncementController;
use App\Http\Controllers\Admin\Member\AutogateController;
use App\Http\Controllers\Admin\Member\CardController;
use App\Http\Controllers\Admin\Member\CommunicationController;
use App\Http\Controllers\Admin\Member\DocumentController;
use App\Http\Controllers\Admin\Member\DueFeeController;
use App\Http\Controllers\Admin\Member\EmailController;
use App\Http\Controllers\Admin\Member\FeeController;
use App\Http\Controllers\Admin\Member\PaymentTransactionController;
use App\Http\Controllers\Admin\Member\TemplateController;
use App\Http\Controllers\Admin\Member\TransactionController;
use App\Http\Controllers\Admin\NavigationController;
use App\Http\Controllers\Admin\PrivilegeController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\Member\RegistrationController;
use App\Http\Controllers\Admin\SubdivisionController;
use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\Member\LotController;
use App\Http\Controllers\Member\AnnouncementActionsController;
use App\Http\Controllers\Member\BillingController;
use App\Http\Controllers\Member\BillPaymentController;
use App\Http\Controllers\Member\DirectorsController;
use App\Http\Controllers\Member\NewsController;
use App\Http\Controllers\Member\PaymentAddressController;
use App\Http\Controllers\Member\PaymentController;
use App\Http\Controllers\Member\Profile\ChangePasswordController;
use App\Http\Controllers\Member\Profile\DesigneeController;
use App\Http\Controllers\Member\Profile\InformationController;
use App\Http\Controllers\Member\Profile\NotificationController;
use App\Http\Controllers\Member\Profile\ProfileController;


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

    //show users

    //hoa admin routes
    Route::group(['prefix' => 'admin', 'middleware' => 'hoa_admin'], function () {

        //dashboard controller
        Route::get('/dashboard',DashboardController::class);

        //member routes
        Route::apiResource('/member', RegistrationController::class);
        Route::put('/member/change/status/{id}', [RegistrationController::class, 'change_status']);
        Route::get('/member/search/data',[RegistrationController::class,'search_member']);

        //user management routes
        Route::apiResource('/user',UsersController::class)->except('create','store');
        Route::get('/user/show/email',[UsersController::class,'show_email']);
        Route::put('/user/add/user/{id}',[UsersController::class,'add_user']);
        Route::get('/user/show/subdivision',[UsersController::class,'show_subdivision']);
        Route::put('/user/change/status/{id}', [UsersController::class, 'change_status']);
        Route::get('/user/search/data',[UsersController::class,'search_user']);


        //dropdown search
        Route::get('/search/show/email/data',[UsersController::class,'search_show_email']);
        Route::get('/search/show/subdivision/data',[UsersController::class,'search_show_subdivision']);

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
        Route::get('/due/show/schedule',[DueController::class,'show_schedule']);
        Route::put('/due/change/status/{id}', [DueController::class, 'change_status']);
        Route::get('/due/show/unit',[DueController::class,'units']);

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
        Route::get('/announcement/search/data',[AnnouncementController::class,'search_announcement']);

        //rfid routes
        Route::apiResource('/rfid',CardController::class);
        Route::get('/rfid/search/data',[CardController::class,'search_rfid']);
        Route::get('/rfid/show/email',[CardController::class,'show_email']);

        //privilege transaction
        Route::get('/transaction/{id}/rfid',[TransactionController::class,'index']);
        Route::apiResource('/transaction',TransactionController::class)->only('delete','store');
        Route::get('/transaction/search/data',[TransactionController::class,'search_transaction']);
        //autogate
        Route::apiResource('/autogate',AutogateController::class);
        Route::get('/autogate/search/data',[AutogateController::class,'search_autogate']);
        Route::get('/autogate/templates/data',[AutogateController::class,'template']);
        Route::get('/autogate/user/subdivision',[AutogateController::class,'user_subdivision']);

        //autogate template
        Route::apiResource('/template',TemplateController::class);
        Route::get('/template/search/data',[TemplateController::class,'search_template']);

        //email
        Route::apiResource('/email',EmailController::class);
        Route::get('/email/search/data',[EmailController::class,'search_email']);
        Route::get('/email/templates/data',[EmailController::class,'communication']);

        //communication/email template
        Route::apiResource('/communication',CommunicationController::class);
        Route::get('/communication/search/data',[CommunicationController::class,'search_communication']);

        //duefee
        Route::get('duefee',[DueFeeController::class,'index']);
        Route::get('/due/subdivision/lot/{id}',[DueFeeController::class,'subdivision_fees']);
        Route::get('/duefee/search/data',[DueFeeController::class,'search_due_fee']);

        //other fee
        Route::apiResource('/fee',FeeController::class)->except('index');
        Route::get('/fee/{data}/lot',[FeeController::class,'index']);
        Route::get('/fee/search/data',[FeeController::class,'search_fee']);

        //paymentTransaction
        Route::get('/payment/transaction/{id}',[PaymentTransactionController::class,'index']);
        Route::apiResource('/payment/transaction',PaymentTransactionController::class)->only('update','show');
    });

    Route::group(['prefix'=>'member'],function (){
        Route::resource('information',InformationController::class)->only(['index','update']);
        Route::resource('notification',NotificationController::class)->only('index','update');
        Route::post('changePassword',[ChangePasswordController::class,'changePassword']);
        Route::resource('designee',DesigneeController::class)->except(['update','show']);
        Route::get('/profile',ProfileController::class);

       //dashboard
        Route::get('dashboard',\App\Http\Controllers\Member\DashboardController::class);
        Route::get('news',NewsController::class);
        Route::get('director',DirectorsController::class);
        Route::get('events',\App\Http\Controllers\Member\AnnouncementController::class);
        Route::get('/show/events/{id}',[AnnouncementActionsController::class,'showEvent']);
        Route::get('/show/news/{id}',[AnnouncementActionsController::class,'showNews']);
        Route::get('/billing/{id}',BillingController::class);
        Route::get('/bill/payment/{id}',BillPaymentController::class);
        Route::get('payment',PaymentController::class);
        Route::post('/bill/payment/cash/{id}',PaymentAddressController::class);
    });
    Route::get('/navigation',NavigationController::class);
    Route::post('/logout', [AuthController::class, 'logout']);

});


Route::post('/reset-password', [RegistrationController::class,'submit_reset_password_form']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
