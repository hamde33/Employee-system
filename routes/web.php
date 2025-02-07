<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Livewire\LeaveRequestComponent;
use App\Livewire\EmployeeComponent;
use App\Http\Controllers\PdfController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App;

// 1) المصادقة

Route::group(['prefix' => LaravelLocalization::setLocale()], function () {


Auth::routes();

// 2) عند دخول "/" نتوجه إلى "/login"
Route::get('/', function () {
    return redirect('/login');
});

// 3) مجموعة تتطلب أن يكون المستخدم مسجّلاً (auth)
Route::middleware('auth')->group(function() {

    // صفحة /home
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // 4) مجموعة فرعية تتطلب أيضاً أن يكون "admin"
    Route::middleware('admin')->group(function() {
        // أي مسارات خاصة بالمدير
        Route::get('/pdf/leave-requests', [PdfController::class, 'generateLeaveRequestsPdf'])->name('pdf.leave_requests');

        Route::get('/employees', EmployeeComponent::class)->name('employees.index');
        Route::get('/leave-requests', LeaveRequestComponent::class)->name('leave-requests.index');
        Route::resource('users', UserController::class);
    });
});
});
Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'ar'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
});