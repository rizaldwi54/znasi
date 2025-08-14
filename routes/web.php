<?php

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Admin\DataController;
use App\Http\Controllers\Admin\SpotController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\User\UserProfileController;
use App\Http\Controllers\Admin\CenterPointController;
use App\Http\Controllers\Admin\AdminProfileController;
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

    Route::get('/dash', [DashboardController::class, 'dash'])->name('dash');
    Route::get('/center-point/data', [DataController::class, 'centerpoint'])->name('center-point.data');
    Route::get('/spot/data', [DataController::class, 'spot'])->name('spot.data');
    Route::resource('adminprofile', AdminProfileController::class);
    Route::resource('center-point', (CenterPointController::class));
    Route::resource('spot', (SpotController::class));
});
Route::group(['middleware' => 'auth:user'], function () {
    Route::match(['get', 'post'], '/user/home', [UserDashboardController::class, 'index'])->name('user.dashboard.index');
    Route::get('/map', [UserDashboardController::class, 'spots']);
    Route::get('/registrasi', [UserDashboardController::class, 'registrasi']);
    Route::get('/detail-spot/{slug}', [UserDashboardController::class, 'detailSpot'])->name('detail-spot');
    Route::resource('userprofile', RegisterController::class);
});

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('email')
    );

    return $status === Password::ResetLinkSent
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token' => 'required',
        'email' => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ])->setRememberToken(Str::random(60));

            $user->save();

            event(new PasswordReset($user));
        }
    );

    return $status === Password::PasswordReset
        ? redirect()->route('login')->with('status', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

Route::get('/verify', [AuthController::class, 'ShowVerification'])->name('custom.verification.form');
Route::post('/verification', [AuthController::class, 'VerificationVerify'])->name('custom.verificaton.verify');

Route::middleware('auth:user')->group(function(){
    Route::get('/user/profile', [UserProfileController::class, 'UserProfile'])->name('user.profile');
    Route::post('/user/profile/store', [UserProfileController::class, 'ProfileStore'])->name('profile.store');
    Route::post('/user/password/update', [UserProfileController::class, 'PasswordUpdate'])->name('user.password.update');
});
Route::middleware('auth:admin')->group(function(){
    Route::get('/admin/profile', [AdminProfileController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/store', [AdminProfileController::class, 'store'])->name('admin.profile.store');
    Route::post('/admin/password/update', [AdminProfileController::class, 'AdminPasswordUpdate'])->name('admin.password.update');
});


