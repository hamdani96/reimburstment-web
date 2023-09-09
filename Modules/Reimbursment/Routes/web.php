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
use Modules\Reimbursment\Http\Controllers\ReimbursmentController;

Route::middleware(['auth'])->group(function() {
    Route::prefix('reimbursement')->group(function() {
        Route::get('ajax', [ReimbursmentController::class, 'ajax'])->name('reimbursement.ajax');
    });

    Route::resource('reimbursement', 'ReimbursmentController');
});