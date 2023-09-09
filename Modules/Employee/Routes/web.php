<?php

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

use Illuminate\Support\Facades\Route;
use Modules\Employee\Http\Controllers\EmployeeController;

Route::middleware(['auth'])->group(function() {
    Route::prefix('employee')->group(function() {
        Route::get('ajax', [EmployeeController::class, 'ajax'])->name('employee.ajax');
    });

    Route::resource('employee', 'EmployeeController');
});
