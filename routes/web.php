<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceStaffController;
use App\Http\Controllers\Site\ServiceAppointmentController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\Site\CustomerAuthController;
use App\Http\Controllers\AppointmentController;

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
//     return view('welcome');
// });


Auth::routes();

Route::get('/admin', [HomeController::class, 'index'])->name('home');
  
Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('serviceStaff', ServiceStaffController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('appointments', AppointmentController::class);
});

Route::resource('/', SiteController::class);

Route::get('customer-login', [CustomerAuthController::class, 'index']);
Route::post('customer-post-login', [CustomerAuthController::class, 'postLogin']); 
Route::get('customer-registration', [CustomerAuthController::class, 'registration']);
Route::post('customer-post-registration', [CustomerAuthController::class, 'postRegistration']); 
Route::get('customer-logout', [CustomerAuthController::class, 'logout']);

// appointments
Route::get('booking/{id}', [ServiceAppointmentController::class, 'create']);
Route::post('cancelBooking/{id}', [ServiceAppointmentController::class, 'cancel']);
Route::resource('booking', ServiceAppointmentController::class);
