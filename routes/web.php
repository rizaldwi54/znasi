<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\FormRegisController;
use App\Http\Controllers\Admin\DataController;
use App\Http\Controllers\Admin\SpotController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CenterPointController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\DashboardController as ControllersUserDashboardController;
use App\Http\Controllers\User\UserDashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'verify'])->name('auth.verify');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


Route::group(['middleware' => 'auth:admin'], function () {

    Route::match(['get', 'post'], '/admin/home', [DashboardController::class, 'index'])->name('admin.dashboard.index');
    // Route::get('/table', [TableLocController::class, 'index'])->name('table');
    Route::get('/dash', [DashboardController::class, 'dash'])->name('dash');
    Route::get('/center-point/data', [DataController::class, 'centerpoint'])->name('center-point.data');
    Route::get('/spot/data', [DataController::class, 'spot'])->name('spot.data');
    // Route::get('/json', [AdminController::class, 'json'])->name('json');
    Route::resource('center-point', (CenterPointController::class));
    Route::resource('spot', (SpotController::class));
});
Route::group(['middleware' => 'auth:user'], function () {
    Route::match(['get', 'post'], '/user/home', [UserDashboardController::class, 'index'])->name('user.dashboard.index');
    Route::get('/map',[UserDashboardController::class,'spot']);
    Route::get('/detail-spot/{slug}',[UserDashboardController::class,'detailSpot'])->name('detail-spot');
    
    // Route::get('/tabel/pdf', [FormRegisController::class, 'pdf'])->name('tabel.pdf');
    // Route::get('/tabel/download/pdf', [FormRegisController::class, 'download_pdf'])->name('tabel.download.pdf');
    
});