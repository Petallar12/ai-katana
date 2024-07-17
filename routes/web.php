<?php


use App\Http\Controllers\Dashboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataBasisController;
use App\Http\Controllers\DataGraphController;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\ServersideController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AccountsectionController;
use App\Http\Controllers\Dashboard_2023Controller;
use App\Http\Controllers\Dashboard_2024Controller;
use App\Http\Controllers\DataBasis_2023Controller;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\GraphDashboardController;
use App\Http\Controllers\Notification_2023Controller;
use App\Http\Controllers\Accountsection_2023Controller;
use App\Http\Controllers\Accountsection_2024Controller;
use App\Http\Controllers\GraphDashboard_2023Controller;
use App\Http\Controllers\AccountsectionTravelController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Dashboard_Index2023Controller;
use App\Http\Controllers\Dashboard_Index2024Controller;
use App\Http\Controllers\Databasis_2024IndexController;
use App\Http\Controllers\Databasis_2023IndexController;
use App\Http\Controllers\Source_InquiryController;
use App\Http\Controllers\DataBasis_2024Controller;
use App\Http\Controllers\ClaimsController;

use App\Http\Controllers\GraphDashboard_2024Controller;

use App\Http\Controllers\Comparing2023Controller;
use App\Http\Controllers\RegistrationController;
use App\Mail\HappyBirthdayLukeMedicalMail;
use App\Mail\HappyBirthdayJuscallMail;
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

// Route::get('/', function () {
//     return view('/home');
// });

//auth
Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/privacy', function () {
    return view('/privacy');
});

//2022
Route::get("/accountsection/create",[AccountsectionController::class, 'create'])->middleware('auth');
Route::post("/accountsection",[AccountsectionController::class, 'store'])->middleware('auth');
Route::get("/accountsection/index",[AccountsectionController::class, 'index'])->middleware('auth');
Route::get("/accountsection/{id}/edit",[AccountsectionController::class, 'edit'])->middleware('auth');
Route::get("/accountsection/{id}",[AccountsectionController::class, 'show'])->middleware('auth');
Route::patch("/accountsection/{id}",[AccountsectionController::class, 'update'])->middleware('auth');
Route::delete("/accountsection/{id}",[AccountsectionController::class, 'destroy'])->middleware('auth');
// Route::post('/copy-client/{id}', [ClientController::class, 'copyClient']);



//you can put route here so only admin can see
Route::prefix('admin')->middleware('auth')->group(function(){

});

//Calculator
Route::get("/calculator/bupa", [CalculatorController::class, 'bupa'])->middleware('auth');
Route::post("/calculator/compute", [CalculatorController::class, 'bupa_compute'])->middleware('auth');
Route::get("/calculator/aetna", [CalculatorController::class, 'aetna'])->middleware('auth');
Route::post("/calculator/aetna", [CalculatorController::class, 'aetna_compute'])->middleware('auth');
Route::get("/calculator/allianz", [CalculatorController::class, 'allianz'])->middleware('auth');
Route::post("/calculator/allianz", [CalculatorController::class, 'allianz_compute'])->middleware('auth');
Route::get("/calculator/ema", [CalculatorController::class, 'ema'])->middleware('auth')->middleware('auth');
Route::post("/calculator/ema", [CalculatorController::class, 'ema_compute'])->middleware('auth');



//DashBoard
// Route::get("/dashboard", [App\Http\Controllers\DashboardController::class, 'users'])->middleware('auth');
Route::get("/dashboard", [DashboardController::class, 'users'])->middleware('auth');
Route::get("/2023/dashboard", [Dashboard_2023Controller::class, 'users'])->middleware('auth');
Route::get("/2024/dashboard", [Dashboard_2024Controller::class, 'users'])->middleware('auth');



// DataBasis
// Route::get("/databasis/close_renewals", [DataBasisController::class,'close_renewals'])->middleware('auth');
// Route::get("/databasis/close_newlives", [DataBasisController::class,'close_newlives'])->middleware('auth');
//2022
Route::get("/databasis/cancellation_newlives", [DataBasisController::class,'cancellation_newlives'])->middleware('auth');

//2023
Route::get("/2023/databasis/cancellation_newlives", [DataBasis_2023Controller::class,'cancellation_newlives'])->middleware('auth');

//2024
Route::get("/2024/databasis/cancellation_newlives", [DataBasis_2024Controller::class,'cancellation_newlives'])->middleware('auth');

//Graph
//Line Graph Existing and Renewals 
Route::get("/lives_2022", [ChartController::class,'index1'])->middleware('auth');
//Total Premiums and Commissions
Route::get("/premium_commission", [ChartController::class,'premium_commission'])->middleware('auth');
//Source of Inquiry
Route::get("/source_inquiry", [ChartController::class,'source_inquiry'])->middleware('auth');
//Insurer
Route::get("/insurer", [ChartController::class,'insurer'])->middleware('auth');

Route::get("/age", [ChartController::class,'age'])->middleware('auth');




//Notification
Route::get('/notification/renewals', [NotificationController::class, 'renewals'])->middleware('auth');
Route::get('/notification/age', [NotificationController::class, 'age'])->middleware('auth');
Route::get('/notification/birthday', [NotificationController::class, 'birthday'])->middleware('auth');

//Notification 2023
Route::get('/2023/notification/renewals', [Notification_2023Controller::class, 'renewals'])->middleware('auth');
Route::post('/2023/notification/send-renewal-email', [Notification_2023Controller::class, 'sendRenewalEmail'])->middleware('auth');
Route::post('/2023/notification/send-renewal-bricon-email', [Notification_2023Controller::class, 'sendRenewalbriconEmail'])->middleware('auth');
Route::post('/2023/notification/send-renewal-lukemed-email', [Notification_2023Controller::class, 'sendRenewallukemedEmail'])->middleware('auth');

//sending email automatically 
Route::get('/2023/notification/send-csv-email', [Notification_2023Controller::class, 'sendCsvEmail']);
Route::post('/2023/notification/send-csv-email', [Notification_2023Controller::class, 'sendCsvEmail']);



//===This is for renewal per month ====//
Route::get('/notification/renewals_per_month', [NotificationController::class, 'renewals_per_month'])->middleware('auth');

Route::get('/2023/notification/renewals_per_month', [Notification_2023Controller::class, 'renewals_per_month'])->middleware('auth');
Route::post('/2023/notification/send-renewal-email', [Notification_2023Controller::class, 'sendRenewalEmail_per_month'])->middleware('auth');
Route::post('/2023/notification/send-renewal-bricon-email', [Notification_2023Controller::class, 'sendRenewalbriconEmail_per_month'])->middleware('auth');
Route::post('/2023/notification/send-renewal-lukemed-email', [Notification_2023Controller::class, 'sendRenewallukemedEmail_per_month'])->middleware('auth');

//sending email automatically 
Route::get('/2023/notification/send-csv-email', [Notification_2023Controller::class, 'sendCsvEmail_per_month']);
Route::post('/2023/notification/send-csv-email', [Notification_2023Controller::class, 'sendCsvEmail_per_month']);


    



Route::get('/2023/notification/age', [Notification_2023Controller::class, 'age']);
Route::get('/2023/notification/birthday', [Notification_2023Controller::class, 'birthday'])->middleware('auth');
Route::post('/2023/notification/send-birthday-email', [Notification_2023Controller::class, 'sendBirthdayEmail'])->middleware('auth');
Route::post('/2023/notification/send-birthday-bricon-email', [Notification_2023Controller::class, 'sendBirthdaybriconEmail'])->middleware('auth');
Route::post('/2023/notification/send-birthday-rig-email', [Notification_2023Controller::class, 'sendBirthdayrigEmail'])->middleware('auth');
Route::post('/2023/notification/send-birthday-lukemed-email', [Notification_2023Controller::class, 'sendBirthdaylukemedEmail'])->middleware('auth');
Route::post('/2023/notification/send-birthday-juscall-email', [Notification_2023Controller::class, 'sendBirthdayjuscallEmail'])->middleware('auth');
Route::post('/2023/notification/send-birthday-lukemedikal-email', [Notification_2023Controller::class, 'sendBirthdaylukemedikalEmail'])->middleware('auth');
Route::post('/2023/notification/send-birthday-lukeinternational-email', [Notification_2023Controller::class, 'sendBirthdayLukeInternationalEmail'])->middleware('auth');




//Line Graph Existing and Renewals 
Route::get("/case_closed", [ChartController::class,'case_closed'])->middleware('auth');
Route::get("/dashboard/lives_2022", [GraphDashboardController::class,'index1'])->middleware('auth');
//Total Premiums and Commissions
Route::get("/dashboard/premium_commission", [GraphDashboardController::class,'premium_commission'])->middleware('auth');
//Source of Inquiry
Route::get("/dashboard/source_inquiry", [GraphDashboardController::class,'source_inquiry'])->middleware('auth');
//Country
Route::get("/dashboard/country", [GraphDashboardController::class,'country'])->middleware('auth');
//insurer
Route::get("/dashboard/insurer", [GraphDashboardController::class,'insurer'])->middleware('auth');
//age
Route::get("/dashboard/age", [GraphDashboardController::class,'age'])->middleware('auth');
//Country premium
Route::get("/dashboard/country_premium", [GraphDashboardController::class,'country_premium'])->middleware('auth');



//2023 Graph in Dashboard


Route::get("/2023/dashboard/lives_2023", [GraphDashboard_2023Controller::class,'index1'])->middleware('auth');
//Total Premiums and Commissions
Route::get("/2023/dashboard/premium_commission", [GraphDashboard_2023Controller::class,'premium_commission'])->middleware('auth');
//Total Premiums and Commissions Normal
Route::get("/2023/dashboard/premium_commission_normal", [GraphDashboard_2023Controller::class,'premium_commission_normal'])->middleware('auth');
//Source of Inquiry
Route::get("/2023/dashboard/source_inquiry", [GraphDashboard_2023Controller::class,'source_inquiry'])->middleware('auth');
//Country
Route::get("/2023/dashboard/country", [GraphDashboard_2023Controller::class,'country'])->middleware('auth');
//insurer
Route::get("/2023/dashboard/insurer", [GraphDashboard_2023Controller::class,'insurer'])->middleware('auth');
//age
Route::get("/2023/dashboard/age", [GraphDashboard_2023Controller::class,'age'])->middleware('auth');
//Country premium
Route::get("/2023/dashboard/country_premium", [GraphDashboard_2023Controller::class,'country_premium'])->middleware('auth');
//Insurer Premium
Route::get("/2023/dashboard/insurer_premium", [GraphDashboard_2023Controller::class,'insurer_premium'])->middleware('auth');




//2023 Routes
Route::get("/2023/accountsection/create",[Accountsection_2023Controller::class, 'create'])->middleware('auth');
Route::post("/2023/accountsection",[Accountsection_2023Controller::class, 'store'])->middleware('auth');
Route::get("/2023/accountsection/index",[Accountsection_2023Controller::class, 'index'])->middleware('auth')->name('index');
Route::get("/2023/accountsection/{id}/edit",[Accountsection_2023Controller::class, 'edit'])->middleware('auth');
Route::get("/2023/accountsection/{id}",[Accountsection_2023Controller::class, 'show'])->middleware('auth');
//Use put or patch its the same   
Route::patch("/2023/accountsection/{id}",[Accountsection_2023Controller::class, 'update'])->middleware('auth');
//Use post its equal to put,patch and delete
Route::delete("/2023/accountsection/{id}",[Accountsection_2023Controller::class, 'destroy'])->middleware('auth');
//Use Post in javascript and not delete because AJax is  block in our server 
Route::post("/2023/accountsection/delete/{id}",[Accountsection_2023Controller::class, 'destroy_2'])->middleware('auth');
Route::post("/2023/accountsection/{id}/transfer", [Accountsection_2023Controller::class, 'transfer'])->middleware('auth')->name('transfer2023');


//Comparing 2022 to 2023
Route::get("/2023/dashboard/renewal_index",[Comparing2023Controller::class, 'renewal_index'])->middleware('auth')->name('renewal_index');
Route::get("/2023/dashboard/cancelled_index",[Comparing2023Controller::class, 'cancelled_index'])->middleware('auth')->name('cancelled_index');
Route::get("/2023/dashboard/lives_2022_index",[Comparing2023Controller::class, 'lives_2022_index'])->middleware('auth')->name('lives_2022_index');



//Dashboard 2023 Index
Route::get("/2023/dashboard_index/source_index",[Dashboard_Index2023Controller::class, 'source_index'])->middleware('auth')->name('source_index_2023');
Route::get("/2023/dashboard_index/insurer_index",[Dashboard_Index2023Controller::class, 'insurer_index'])->middleware('auth')->name('insurer_index_2023');
Route::get("/2023/dashboard_index/country_index",[Dashboard_Index2023Controller::class, 'country_index'])->middleware('auth')->name('country_index_2023');
Route::get("/2023/dashboard_index/age_index",[Dashboard_Index2023Controller::class, 'age_index'])->middleware('auth')->name('age_index_2023');
Route::get("/2023/dashboard_index/country_premium_index",[Dashboard_Index2023Controller::class, 'country_premium_index'])->middleware('auth')->name('country_premium_index_2023');
Route::get("/2023/dashboard_index/insurer_premium_index",[Dashboard_Index2023Controller::class, 'insurer_premium_index'])->middleware('auth')->name('insurer_premium_index_2023');
Route::get("/2023/dashboard_index/insurer_commission_index",[Dashboard_Index2023Controller::class, 'insurer_commission_index'])->middleware('auth')->name('insurer_commission_index_2023');
Route::get("/2023/dashboard_index/case_closed_inquiry_index",[Dashboard_Index2023Controller::class, 'case_closed_inquiry_index'])->middleware('auth')->name('case_closed_inquiry_index_2023');
Route::get("/2023/dashboard_index/newlives_2023_index",[Dashboard_Index2023Controller::class, 'newlives_2023_index'])->middleware('auth')->name('newlives_2023_index_2023');
Route::get("/2023/dashboard_index/existing_2023_index",[Dashboard_Index2023Controller::class, 'existing_2023_index'])->middleware('auth')->name('existing_2023_index_2023');

Route::get("/2023/dashboard/compare_2022_2023", [GraphDashboard_2023Controller::class,'francis'])->middleware('auth');

// Databasis 2023 Index
Route::get("/2023/databasis_index/case_closed_inquiry_index",[Databasis_2023IndexController::class, 'case_closed_inquiry_index'])->middleware('auth')->name('case_closed_inquiry_index_2023');
Route::get("/2023/databasis_index/case_officer_2023_inquiry_index",[Databasis_2023IndexController::class, 'case_officer_2023_inquiry_index'])->middleware('auth')->name('case_officer_2023_inquiry_index');


//Dashboard 2024 Index
Route::get("/2024/dashboard_index/source_index",[Dashboard_Index2024Controller::class, 'source_index'])->middleware('auth')->name('source_index');
Route::get("/2024/dashboard_index/insurer_index",[Dashboard_Index2024Controller::class, 'insurer_index'])->middleware('auth')->name('insurer_index');
Route::get("/2024/dashboard_index/country_index",[Dashboard_Index2024Controller::class, 'country_index'])->middleware('auth')->name('country_index');
Route::get("/2024/dashboard_index/age_index",[Dashboard_Index2024Controller::class, 'age_index'])->middleware('auth')->name('age_index');
Route::get("/2024/dashboard_index/country_premium_index",[Dashboard_Index2024Controller::class, 'country_premium_index'])->middleware('auth')->name('country_premium_index');
Route::get("/2024/dashboard_index/insurer_premium_index",[Dashboard_Index2024Controller::class, 'insurer_premium_index'])->middleware('auth')->name('insurer_premium_index');
Route::get("/2024/dashboard_index/insurer_commission_index",[Dashboard_Index2024Controller::class, 'insurer_commission_index'])->middleware('auth')->name('insurer_commission_index');
// Route::get("/2024/dashboard_index/case_closed_inquiry_index",[Dashboard_Index2024Controller::class, 'case_closed_inquiry_index'])->middleware('auth')->name('case_closed_inquiry_index2024');
Route::get("/2024/dashboard_index/newlives_2024_index",[Dashboard_Index2024Controller::class, 'newlives_2024_index'])->middleware('auth')->name('newlives_2024_index');
Route::get("/2024/dashboard_index/existing_2024_index",[Dashboard_Index2024Controller::class, 'existing_2024_index'])->middleware('auth')->name('existing_2024_index');

// Databasis 2024 Index
Route::get("/2024/databasis_index/case_closed_inquiry_index",[Databasis_2024IndexController::class, 'case_closed_inquiry_index'])->middleware('auth')->name('case_closed_inquiry_index');
Route::get("/2024/databasis_index/case_officer_2024_inquiry_index",[Databasis_2024IndexController::class, 'case_officer_2024_inquiry_index'])->middleware('auth')->name('case_officer_2024_inquiry_index');



//Travel
Route::get("/travel/accountsection/create",[AccountsectionTravelController::class, 'create'])->middleware('auth');
Route::post("/travel/accountsection",[AccountsectionTravelController::class, 'store'])->middleware('auth');
Route::get("/travel/accountsection/index",[AccountsectionTravelController::class, 'index'])->middleware('auth');
Route::get("/travel/accountsection/{id}/edit",[AccountsectionTravelController::class, 'edit'])->middleware('auth');
Route::get("/travel/accountsection/{id}",[AccountsectionTravelController::class, 'show'])->middleware('auth');
Route::patch("/travel/accountsection/{id}",[AccountsectionTravelController::class, 'update'])->middleware('auth');
Route::delete("/travel/accountsection/{id}",[AccountsectionTravelController::class, 'destroy'])->middleware('auth');



//DASHBOARD MONTHLY NEW LIVES 2022
Route::get("/databasis/monthly_newlives", [DataBasisController::class,'monthly_newlives'])->middleware('auth');

//DASHBOARD MONTHLY RENEWALS 2022
Route::get("/databasis/monthly_renewals", [DataBasisController::class,'monthly_renewals'])->middleware('auth');

//DASHBOARD MONTHLY NEW LIVES 2023
Route::get("/2023/databasis/monthly_newlives", [DataBasis_2023Controller::class,'monthly_newlives'])->middleware('auth');

//DASHBOARD MONTHLY RENEWALS 2023
Route::get("/2023/databasis/monthly_renewals", [DataBasis_2023Controller::class,'monthly_renewals'])->middleware('auth');

Route::get('/currency', [CurrencyController::class, 'index'])->name('currency');
// Route::post('/convert', [CurrencyController::class, 'convert'])->name('convert');


//Data Of Graph
Route::get("/2023/2023datagraph/index",[DataGraphController::class, 'index'])->middleware('auth');
Route::get("/2023/2023datagraph/total_commission",[DataGraphController::class, 'total_commission'])->middleware('auth');
Route::get("/2023/2023datagraph/{id}/edit",[DataGraphController::class, 'edit'])->middleware('auth');
Route::get("/2023/2023datagraph/{id}",[DataGraphController::class, 'show'])->middleware('auth');
Route::patch("/2023/2023datagraph/{id}",[DataGraphController::class, 'update'])->middleware('auth');
Route::delete("/2023/2023datagraph/{id}",[DataGraphController::class, 'destroy'])->middleware('auth');



Route::get('/export-csv', [Accountsection_2023Controller::class, 'exportCsv'])->name('export.csv');
Route::get('/export-csv_2024', [Accountsection_2024Controller::class, 'exportCsv_2024'])->name('export_2024.csv');
Route::post('/auth/forgot_password', [ForgotPasswordController::class, 'store'])->name('storecode');
Route::post('/auth/forgot_password/update', [ForgotPasswordController::class, 'updatePassword'])->name('updatePassword');
Route::get("/auth/forgot_password",[ForgotPasswordController::class, 'index']);


// Route::get("/table", [ProductController::class,'getData'])->name('table');
// Route::get("/index", [ServersideController::class,'getData'])->middleware('auth')->name('index');
// Route::delete("/index/{id}",[ServersideController::class, 'destroy'])->middleware('auth')->name('delete');


//2024 Routes
Route::get("/2024/accountsection/create",[Accountsection_2024Controller::class, 'create'])->middleware('auth');
Route::post("/2024/accountsection",[Accountsection_2024Controller::class, 'store'])->middleware('auth');
Route::get("/2024/accountsection/index",[Accountsection_2024Controller::class, 'index2024'])->middleware('auth')->name('index2024');
Route::get("/2024/accountsection/{id}/edit",[Accountsection_2024Controller::class, 'edit'])->middleware('auth');
Route::get("/2024/accountsection/{id}",[Accountsection_2024Controller::class, 'show'])->middleware('auth');
Route::patch("/2024/accountsection/{id}",[Accountsection_2024Controller::class, 'update'])->middleware('auth');
Route::delete("/2024/accountsection/{id}",[Accountsection_2024Controller::class, 'destroy'])->middleware('auth')->name('delete2024');
//Use Post in javascript and not delete because its ban in our server 
Route::post("/2024/accountsection/delete/{id}",[Accountsection_2024Controller::class, 'destroy_2'])->middleware('auth');
Route::post("/2024/accountsection/{id}/transfer", [Accountsection_2024Controller::class, 'transfer'])->middleware('auth')->name('transfer2024');


//DASHBOARD MONTHLY NEW LIVES 2022
Route::get("/2024/databasis/monthly_newlives", [DataBasis_2024Controller::class,'monthly_newlives'])->middleware('auth');
//DASHBOARD MONTHLY RENEWALS 2022
Route::get("/2024/databasis/monthly_renewals", [DataBasis_2024Controller::class,'monthly_renewals'])->middleware('auth');

//2024 Graph in Dashboard
Route::get("/2024/dashboard/lives_2024", [GraphDashboard_2024Controller::class,'index1'])->middleware('auth');
//Total Premiums and Commissions
Route::get("/2024/dashboard/premium_commission", [GraphDashboard_2024Controller::class,'premium_commission'])->middleware('auth');
//Total Premiums and Commissions Normal
Route::get("/2024/dashboard/premium_commission_normal", [GraphDashboard_2024Controller::class,'premium_commission_normal'])->middleware('auth');
//Source of Inquiry
Route::get("/2024/dashboard/source_inquiry", [GraphDashboard_2024Controller::class,'source_inquiry'])->middleware('auth');
//Country
Route::get("/2024/dashboard/country", [GraphDashboard_2024Controller::class,'country'])->middleware('auth');
//insurer
Route::get("/2024/dashboard/insurer", [GraphDashboard_2024Controller::class,'insurer'])->middleware('auth');
//age
Route::get("/2024/dashboard/age", [GraphDashboard_2024Controller::class,'age'])->middleware('auth');
//Country premium
Route::get("/2024/dashboard/country_premium", [GraphDashboard_2024Controller::class,'country_premium'])->middleware('auth');
Route::get("/2024/dashboard/insurer_premium", [GraphDashboard_2024Controller::class,'insurer_premium'])->middleware('auth');

//REgistration
Route::get("registration",[RegistrationController::class, 'create'])->middleware('auth');
Route::post("registration",[RegistrationController::class, 'store'])->middleware('auth');


Route::get('/api/getDataByFullName', [Accountsection_2024Controller::class, 'getDataByFullName'])->name('getDataByFullName');

// Route::get("/2024/accountsection/index",[ClaimsController::class, 'fetchClaimsByClientNameFromClaimsDB'])->middleware('auth');
// Route::get('/2024/accountsection/claims', [ClaimsController::class, 'fetchClaimsByClientNameFromClaimsDB'])->name('fetch.claims');
Route::get('/claims', [App\Http\Controllers\ClaimsController::class, 'fetchClaimsByClientNameFromClaimsDB'])->name('fetch.claims');



Route::get('/2024/databasis/monthly_newlives', [DataBasis_2024Controller::class, 'monthly_newlives'])->middleware('auth');
Route::get('/2024/databasis/monthly_renewals', [DataBasis_2024Controller::class, 'monthly_renewals'])->middleware('auth');
