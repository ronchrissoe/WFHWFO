<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\InputWFAWFO\InputWFAWFOController;
use App\Http\Controllers\ApproveWFAWFO\ApproveWFAWFOController;
use App\Http\Controllers\Master\DepartmentController;
use App\Http\Controllers\Makanan1Controller;
use App\Http\Controllers\ReportWFAWFO\ReportWFAWFOController;
use App\Http\Controllers\Master\MasterKerjaController;
use App\Http\Controllers\Master\MasterMakananController;
use App\Http\Controllers\Master\MasterUserController;
use App\Http\Controllers\Master\MasterPeriodeController;
use App\Http\Controllers\Master\MasterHariLiburController;
use App\Http\Controllers\TestController;

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

Route::get('/offline', function(){
    return '
        <h1 style="text-align: center">Tidak Ada Akses Internet</h1>
    ';
});

//Login
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/validationlogin', [LoginController::class, 'validationlogin'])->name('postlogin');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//Dashboard
Route::get('/test', [DashboardController::class, 'index']);
Route::post('/filter', [DashboardController::class, 'filter'])->name('filter');
Route::get('/dashboard', [DashboardController::class, 'test'])->name('dashboard');
Route::get('/dashboard/percentage', [DashboardController::class, 'percentage']);

//Profil
Route::get('/profile', [ProfileController::class, 'index']);

//Input WFA WFO
Route::get('/inputwfawfo', [InputWFAWFOController::class, 'index'])->name('inputwfawfo.index');
Route::post('/inputwfawfo', [InputWFAWFOController::class, 'store'])->name('inputwfawfo.store');
Route::get('/inputwfawfo/{id}/edit', [InputWFAWFOController::class, 'edit'])->name('inputwfawfo.edit');
Route::get('/inputwfawfo/tanggal', [InputWFAWFOController::class, 'tanggal']);
Route::get('/inputwfawfo/maksimumwfawfo', [InputWFAWFOController::class, 'maksimumwfawfo']);
Route::get('/inputwfawfo/maksimumupdatewfawfo', [InputWFAWFOController::class, 'maksimumupdatewfawfo']);
Route::get('/inputwfawfo/cek_department', [InputWFAWFOController::class, 'cek_department']);
Route::get('/inputwfawfo/cek_jadwal_wfhwfo', [InputWFAWFOController::class, 'cek_jadwal_wfhwfo']);

Route::middleware(['check'])->group(function () {
    Route::prefix('approvewfawfo')->group(function() {
        Route::get('', [ApproveWFAWFOController::class, 'index'])->name('approvewfawfo.index');
        Route::post('/', [ApproveWFAWFOController::class, 'store'])->name('approvewfawfo.store');
        Route::post('/filter', [ApproveWFAWFOController::class, 'filter'])->name('approvewfawfo.filter');
        Route::get('/{id}/edit', [ApproveWFAWFOController::class, 'edit']);
        Route::post('/approve', [ApproveWFAWFOController::class, 'approve'])->name('approvewfawfo.approve');
        Route::post('/approveall', [ApproveWFAWFOController::class, 'approveall'])->name('approvewfawfo.approveall');
        Route::get('/percentage', [ApproveWFAWFOController::class, 'percentage']);
        Route::post('/reject', [ApproveWFAWFOController::class, 'reject'])->name('approvewfawfo.reject');
        Route::get('/maksimumupdatewfawfo', [ApproveWFAWFOController::class, 'maksimumupdatewfawfo']);
    });

    Route::prefix('reportwfawfo')->group(function(){
        Route::get('/', [ReportWFAWFOController::class, 'index']);
        Route::get('/', [ReportWFAWFOController::class, 'test'])->name('report');
        Route::get('/food', [ReportWFAWFOController::class, 'test'])->name('food');
        Route::get('/schedule', [ReportWFAWFOController::class, 'test'])->name('schedule');
        Route::post('/filter', [ReportWFAWFOController::class, 'filter'])->name('report-filter');
        Route::post('/food/filter', [ReportWFAWFOController::class, 'filter'])->name('food-filter');
        Route::post('/schedule/filter', [ReportWFAWFOController::class, 'filter'])->name('schedule-filter');
        Route::get('/percentage', [ReportWFAWFOController::class, 'percentage']);
        Route::get('/exportexcel/{departemen?}/{tanggalmulai?}/{tanggalselesai?}', [ReportWFAWFOController::class, 'exportexcel']);
        Route::get('/percentage', [ReportWFAWFOController::class, 'percentage']);
    });


    //Master Kerja
    Route::get('/masterkerja', [MasterKerjaController::class, 'index'])->name('masterkerja.index');
    Route::post('/masterkerja', [MasterKerjaController::class, 'store'])->name('masterkerja.store');
    Route::get('/masterkerja/{id}/edit', [MasterKerjaController::class, 'edit'])->name('masterkerja.update');
    Route::delete('/masterkerja/{id}', [MasterKerjaController::class, 'destroy']);

    //Master Makanan
    Route::get('/mastermakanan', [MasterMakananController::class, 'index'])->name('mastermakanan.index');
    Route::post('/mastermakanan', [MasterMakananController::class, 'store'])->name('mastermakanan.store');
    Route::get('/mastermakanan/{id}/edit', [MasterMakananController::class, 'edit'])->name('mastermakanan.update');
    Route::delete('/mastermakanan/{id}', [MasterMakananController::class, 'destroy']);

    //Master User
    Route::get('/masteruser', [MasterUserController::class, 'index'])->name('masteruser.index');
    Route::post('/masteruser', [MasterUserController::class, 'store'])->name('masteruser.store');
    Route::get('/masteruser/{id}/edit', [MasterUserController::class, 'edit'])->name('masteruser.update');
    Route::delete('/masteruser/{id}', [MasterUserController::class, 'destroy'])->name('masteruser.destroy');
    Route::get('/masteruser/generate_nik', [MasterUserController::class, 'generate_nik']);

    //Master Periode
    Route::get('/masterperiode', [MasterPeriodeController::class, 'index'])->name('masterperiode.index');
    Route::post('/masterperiode', [MasterPeriodeController::class, 'store'])->name('masterperiode.store');
    Route::get('/masterperiode/{id}/edit', [MasterPeriodeController::class, 'edit'])->name('masterperiode.update');
    Route::delete('/masterperiode/{id}', [MasterPeriodeController::class, 'destroy']);

    //Master Hari Libur
    Route::get('/masterharilibur', [MasterHariLiburController::class, 'index'])->name('masterharilibur.index');
    Route::post('/masterharilibur', [MasterHariLiburController::class, 'store'])->name('masterharilibur.store');
    Route::get('/masterharilibur/{id}/edit', [MasterHariLiburController::class, 'edit'])->name('masterharilibur.update');
    Route::delete('/masterharilibur/{id}', [MasterHariLiburController::class, 'destroy']);

    Route::get('masteruser/dept', [DepartmentController::class, 'dept'])->name('masterdepartment');
    Route::post('dept/update/{code}', [DepartmentController::class, 'update'])->name('dept-update');
});
