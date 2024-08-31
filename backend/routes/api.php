<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

RateLimiter::for('global', function (Request $request) {
    return Limit::perMinute(1000)->by($request->ip());
});

Route::prefix('services/smartpaud')->group(function () {

    // Rute untuk register dan signature
    Route::post('register/header', [App\Http\Controllers\Admin\Master\RegistrationController::class, 'register']);
    Route::post('generate-signature/{idRegister}/{clientKey}/{serverKey}/{secretKey}/{timestamp}', [App\Http\Controllers\Admin\Master\RegistrationController::class, 'generateSignature']);
    Route::post('verify-signature', [App\Http\Controllers\Admin\Master\RegistrationController::class, 'verifySignature']);

    Route::middleware('throttle:global')->group(function () {

        Route::post('login', [App\Http\Controllers\Auth\AuthController::class, 'login']);

        Route::get('provinces', [App\Http\Controllers\Admin\Master\Region\RegionController::class, 'getProvinces']);
        Route::get('provinces/{provinsi_id}/kabupatens', [App\Http\Controllers\Admin\Master\Region\RegionController::class, 'getKabupatens']);
        Route::get('kabupatens/{kabupaten_id}/kecamatans', [App\Http\Controllers\Admin\Master\Region\RegionController::class, 'getKecamatans']);
        Route::get('kecamatans/{kecamatan_id}/kelurahans', [App\Http\Controllers\Admin\Master\Region\RegionController::class, 'getKelurahans']);

        Route::middleware(['auth:sanctum'])->group(function () {

            Route::get('dashboard', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'index']);

            Route::apiResource('roles', App\Http\Controllers\Admin\Master\RolesController::class);
            Route::apiResource('profile', App\Http\Controllers\Admin\Profile\ProfileController::class);
            Route::apiResource('users', App\Http\Controllers\Admin\Users\UsersController::class);
            Route::apiResource('logingusers', App\Http\Controllers\Admin\Master\LogingUsers\LogingUsersController::class);
            Route::apiResource('agama', App\Http\Controllers\Admin\Master\AgamaController::class);
            Route::apiResource('jeniskelamin', App\Http\Controllers\Admin\Master\JenisKelaminController::class);
            Route::apiResource('golongandarah', App\Http\Controllers\Admin\Master\GolonganDarahController::class);
            Route::apiResource('pekerjaan', App\Http\Controllers\Admin\Master\PerkerjaanController::class);
            Route::apiResource('pendidikan', App\Http\Controllers\Admin\Master\PendidikanController::class);
            Route::apiResource('statusperkawinan', App\Http\Controllers\Admin\Master\StatusPerkawinanController::class);
            Route::apiResource('warganegara', App\Http\Controllers\Admin\Master\WarganegaraController::class);
            Route::apiResource('hubungankeluarga', App\Http\Controllers\Admin\Master\HubunganKeluargaController::class);
            Route::apiResource('jabatan', App\Http\Controllers\Admin\Master\JabatanController::class);
            Route::apiResource('jenispegawai', App\Http\Controllers\Admin\Master\JenisPegawaiController::class);
            Route::apiResource('golonganpegawai', App\Http\Controllers\Admin\Master\GolonganPegawaiController::class);
            Route::apiResource('unitkerja', App\Http\Controllers\Admin\Master\UnitKerjaController::class);
            Route::apiResource('kategorypegawai', App\Http\Controllers\Admin\Master\KategorypegawaiController::class);
            Route::apiResource('statuspegawai', App\Http\Controllers\Admin\Master\StatusPegawaiController::class);
            Route::apiResource('kelompokpegawai', App\Http\Controllers\Admin\Master\KelompokPegawaiController::class);
            Route::apiResource('shiftkerja', App\Http\Controllers\Admin\Master\ShiftKerjaController::class);
            Route::apiResource('pegawai', App\Http\Controllers\Admin\Master\PegawaiController::class);
            Route::apiResource('statuspendaftaran', App\Http\Controllers\Admin\Master\StatusPendaftaranController::class);

            Route::get('get-logingusers/{tglawal}/{tglakhir}', [App\Http\Controllers\Admin\Master\LogingUsers\LogingUsersController::class, 'GetUsingFilters']);

            Route::post('logout', [App\Http\Controllers\Auth\AuthController::class, 'logout']);
            Route::post('forgot-password', [App\Http\Controllers\Auth\AuthController::class, 'forgotPassword']);
            Route::post('reset-password', [App\Http\Controllers\Auth\AuthController::class, 'resetPassword']);
            Route::post('change-password', [App\Http\Controllers\Auth\AuthController::class, 'changePassword']);
            Route::post('logout/lock-screen', [App\Http\Controllers\Auth\AuthController::class, 'logoutLockScreen']);
        });
    });
});
