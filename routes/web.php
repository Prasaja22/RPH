<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DatastockController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LotnumberController;
use App\Http\Controllers\ManpowerController;
use App\Http\Controllers\OrderControllerr;
use App\Http\Controllers\PartnumberController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;
use PhpOffice\PhpSpreadsheet\Chart\DataSeries;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::get('/register', [LoginController::class, 'indexRegister'])->middleware('auth');

Route::post('/register', [LoginController::class,'store']);
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'destroy'])->middleware('auth');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');

Route::get('/import-data/order', [DashboardController::class, 'indexImportDataOrder'])->middleware('auth');

Route::get('/import-data/manpower', [DashboardController::class, 'indexImportDataManpower'])->middleware('auth');
Route::get('/team', [DashboardController::class, 'indexTeam'])->middleware('auth');
Route::get('/part-number', [DashboardController::class, 'indexPartNumber'])->middleware('auth');
Route::get('/lot-number', [DashboardController::class, 'indexLotNumber'])->middleware('auth');
Route::get('/data-stock', [DashboardController::class, 'indexDataStock'])->middleware('auth');
Route::get('/penjadwalan', [DashboardController::class, 'indexPenjadwalan'])->middleware('auth');


Route::post('/manpower-import', [ManpowerController::class, 'importExcel'])->middleware('auth');
Route::post('/simpan-manpower', [ManpowerController::class, 'store'])->middleware('auth');
Route::put('/edit-manpower/{id}', [ManpowerController::class, 'update'])->middleware('auth');
Route::delete('/hapus-manpower/{id}', [ManpowerController::class, 'destroy'])->middleware('auth');
Route::delete('/reset-manpower', [ManpowerController::class, 'destroyAll'])->middleware('auth');

Route::post('/tambah-team', [TeamController::class, 'store'])->middleware('auth');
Route::put('/edit-team/{id}', [TeamController::class, 'update'])->middleware('auth');
Route::delete('/hapus-team/{id}', [TeamController::class, 'destroy'])->middleware('auth');

Route::post('/simpan-partnumber', [PartnumberController::class, 'store'])->middleware('auth');
Route::post('/import-partnumber', [PartnumberController::class, 'importExcelPartNumber'])->middleware('auth');
Route::put('/edit-partnumber/{id}', [PartnumberController::class, 'update'])->middleware('auth');
Route::delete('/hapus-partnumber/{id}', [PartnumberController::class, 'destroy'])->middleware('auth');
Route::delete('/reset-partnumber', [PartnumberController::class, 'destroyAll'])->middleware('auth');

Route::post('/simpan-lotnumber',  [LotnumberController::class, 'store'])->middleware('auth');
Route::post('/import-lotnumber', [LotnumberController::class, 'importExcelLotnumber'])->middleware('auth');
Route::put('/edit-lotnumber/{id}', [LotnumberController::class, 'update'])->middleware('auth');
Route::delete('/hapus-lotnumber/{id}', [LotnumberController::class, 'destroy'])->middleware('auth');
Route::delete('/reset-lotnumber', [LotnumberController::class, 'destroyAll'])->middleware('auth');

Route::post('/simpan-data-stock', [DatastockController::class, 'store'])->middleware('auth');
Route::post('/import-data-stock', [DatastockController::class, 'importExcelDataStock'])->middleware('auth');
Route::delete('/reset-data-stock', [DatastockController::class, 'destroyAll'])->middleware('auth');

Route::post('/simpan-schedule', [ScheduleController::class, 'store'])->middleware('auth');
Route::get('/schedule-add-details/{id}', [ScheduleController::class, 'show'])->middleware('auth');
Route::post('schedules/{id}/add-detail', [ScheduleController::class, 'addDetail'])->name('schedules.addDetail')->middleware('auth');
Route::delete('/hapus-detail-schedule/{id}', [ScheduleController::class, 'deleteDetail'])->name('details.delete')->middleware('auth');
Route::get('details/{id}/edit', [ScheduleController::class, 'editDetail'])->name('details.edit')->middleware('auth');
Route::post('details/{id}', [ScheduleController::class, 'updateDetail'])->name('details.update')->middleware('auth');
Route::delete('/hapus-penjadwalan/{id}', [ScheduleController::class, 'destroy'])->middleware('auth');

Route::post('/get-print', [ScheduleController::class, 'getPrint'])->name('get.print')->middleware('auth');

Route::post('/simpan-order', [OrderControllerr::class, 'store'])->middleware('auth');
Route::put('/edit-order/{id}', [OrderControllerr::class, 'update'])->middleware('auth');
Route::delete('/hapus-order/{id}', [OrderControllerr::class, 'destroy'])->middleware('auth');
Route::post('/import-order', [OrderControllerr::class, 'importExcelOrder'])->middleware('auth');
Route::delete('/reset-order', [OrderControllerr::class, 'destroyAll'])->middleware('auth');

Route::delete('/hapus-datastock/{id}', [DatastockController::class, 'destroy'])->middleware('auth');
Route::put('/edit-data-stock/{id}', [DatastockController::class, 'update'])->middleware('auth');
