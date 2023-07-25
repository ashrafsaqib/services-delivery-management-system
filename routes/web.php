<?php

use App\Http\Controllers\AffiliateController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    HomeController,
    RoleController,
    UserController,
    ServiceController,
    ServiceStaffController,
    CustomerController,
    AssistantSupervisorController,
    CashCollectionController,
    HolidayController,
    ManagerController,
    ServiceCategoryController,
    OrderController,
    PartnerController,
    StaffGroupController,
    StaffHolidayController,
    StaffZoneController,
    SupervisorController,
    TimeSlotController,
    TransactionController,
    AppController,
    
};

use App\Http\Controllers\Site\{
    CheckOutController,
    CustomerAuthController,
    SiteController,
    SiteOrdersController,
    SiteCashCollectionController,
    
};

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


Auth::routes();

Route::get('/admin', [HomeController::class, 'index'])->name('home');
  
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('serviceStaff', ServiceStaffController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('serviceCategories', ServiceCategoryController::class);
    Route::resource('affiliates', AffiliateController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('staffZones', StaffZoneController::class);
    Route::resource('staffGroups', StaffGroupController::class);
    Route::resource('managers', ManagerController::class);
    Route::resource('supervisors', SupervisorController::class);
    Route::resource('timeSlots', TimeSlotController::class);
    Route::resource('assistantSupervisors', AssistantSupervisorController::class);
    Route::resource('staffHolidays', StaffHolidayController::class);


    Route::post('serviceFilter', [ServiceController::class, 'filter']);
    Route::post('serviceStaffFilter', [ServiceStaffController::class, 'filter']); 
    Route::post('customerFilter', [CustomerController::class, 'filter']); 
    Route::post('affiliateFilter', [AffiliateController::class, 'filter']); 
    Route::post('userFilter', [UserController::class, 'filter']); 
    Route::post('managerFilter', [ManagerController::class, 'filter']); 
    Route::post('supervisorFilter', [SupervisorController::class, 'filter']);
    Route::post('assistantSupervisorFilter', [AssistantSupervisorController::class, 'filter']);
     
    Route::get('serviceFilterCategory', [ServiceController::class, 'filter']); 

    Route::get('orderCSV', [OrderController::class,'downloadCSV']);

    Route::get('holidays', [HolidayController::class, 'index']);
    Route::post('/holidays/crud-ajax', [HolidayController::class, 'store']);
    Route::get('time-slots', [TimeSlotController::class,'slots']);
    Route::get('staff-by-group', [TimeSlotController::class,'staff_group']);
    
    Route::resource('cashCollection', CashCollectionController::class);
    Route::get('staffCashCollection',[CashCollectionController::class, 'staffCashCollection'])->name('staffCashCollection');
    Route::get('cashCollection/create/{order}',[CashCollectionController::class, 'create'])->name('cashCollection.create');

    Route::get('profile/{id}', [HomeController::class, 'profile'])->name('profile'); 
    Route::post('updateProfile/{id}', [HomeController::class, 'updateProfile'])->name('updateProfile'); 

});

Route::get('/', [SiteController::class, 'index']);
Route::get('serviceDetail/{id}', [SiteController::class, 'show']);
Route::get('updateZone', [SiteController::class, 'updateZone']);

Route::get('customer-login', [CustomerAuthController::class, 'index']);
Route::post('customer-post-login', [CustomerAuthController::class, 'postLogin']); 
Route::get('customer-registration', [CustomerAuthController::class, 'registration']);
Route::post('customer-post-registration', [CustomerAuthController::class, 'postRegistration']); 
Route::get('customer-logout', [CustomerAuthController::class, 'logout']);


Route::resource('order', SiteOrdersController::class);
Route::get('order-update/{order}', [OrderController::class, 'updateOrderStatus'])->name('updateOrderStatus');
Route::resource('transactions', 'App\Http\Controllers\Site\TransactionController');
Route::get('manageAppointment', 'App\Http\Controllers\Site\ManagerController@appointment');
Route::get('supervisor', 'App\Http\Controllers\Site\ManagerController@supervisor');
Route::get('addToCart/{id}', [CheckOutController::class, 'addToCart']);
Route::get('removeToCart/{id}', [CheckOutController::class, 'removeToCart']);
Route::post('addressSession', [CheckOutController::class, 'addressSession']);
Route::post('timeSlotsSession', [CheckOutController::class, 'timeSlotsSession']);
Route::resource('cart', CheckOutController::class);
Route::get('bookingStep', [CheckOutController::class, 'bookingStep']);
Route::get('locationStep', [CheckOutController::class, 'locationStep']); 
Route::get('confirmStep', [CheckOutController::class, 'confirmStep']); 
Route::get('slots', [CheckOutController::class,'slots']);
Route::get('staff-group', [CheckOutController::class,'staff_group']);
Route::get('staffOrderCSV', [SiteOrdersController::class, 'downloadCSV']);
Route::post('saveLocation', [SiteController::class, 'saveLocation']);


// app url

Route::get('appOrders', [AppController::class,'orders']);
Route::get('appUser', [AppController::class,'user']);
Route::get('appAddOrderComment/{order}', [AppController::class,'addComment']);
Route::get('appRescheduleOrder/{order}', [AppController::class,'reschedule']);
