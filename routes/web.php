<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;

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




Route::get('/', function () {
    return view('dashboard');
})->middleware('auth');



Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//auth route for admin
Route::group(['middleware' => ['auth', 'role:admin']], function() {
    
    Route::get('/dashboard/new-employee', [EmployeeController::class, 'create'])->name('employee.register');
    Route::post('/dashboard/register', [EmployeeController::class, 'store'])->name('employee.store');
    Route::get('/dashboard/edit-employee/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('/dashboard/update-empoyee/{id}', [EmployeeController::class, 'update'])->name('employee.update');    
    Route::get('/dashboard/employee-data', [EmployeeController::class, 'index'])->name('dashboard.employeeData');    
    
});

// for users
Route::group(['middleware' => ['auth', 'role:user']], function() {
    
    Route::get('/dashboard/attendance', [AttendanceController::class, 'index'])->name('dashboard.attendance');
    Route::get('/dashboard/attendance/chechIn/{id}/{type}', [AttendanceController::class, 'store'])->name('checkIn');
    Route::get('/dashboard/attendance/checkOut/{id}/{type}', [AttendanceController::class, 'update'])->name('checkOut');    
    
});

require __DIR__ . '/auth.php';
