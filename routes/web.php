<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\TourController;


// store dardboard
use App\Http\Controllers\DashboardController;




// income
Route::get('/admin/income', [DashboardController::class, 'income'])->name('admin.income');
// booking
Route::get('/admin/booking', [DashboardController::class, 'bookingCount'])->name('admin.bookingCount');
// tour
Route::get('/admin/tours/count', [DashboardController::class, 'tourCount'])->name('admin.tourCount');


Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/', [AuthController::class, 'login'])->name('login.post');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'storeRegister'])->name('register.post');

Route::middleware(['auth', 'role:admin'])->group(function () {
    
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/booking', function () {
        return view('admin.bookings.index');
    })->name('admin.bookings.index');

    Route::get('/admin/booking', [BookingController::class, 'index'])->name('admin.bookings.index');
    Route::get('/admin/booking/show/{booking}', [BookingController::class, 'show'])->name('admin.bookings.show');
    Route::get('/admin/booking/create', [BookingController::class, 'create'])->name('admin.bookings.create');
    Route::post('/admin/booking', [BookingController::class, 'store'])->name('admin.bookings.store');
    Route::delete('/admin/booking/{booking}', [BookingController::class, 'destroy'])->name('admin.bookings.destroy');
    // edit
    Route::get('/admin/booking/{booking}/edit', [BookingController::class, 'edit'])->name('admin.bookings.edit');
    Route::put('/admin/booking/{booking}', [BookingController::class, 'update'])->name('admin.bookings.update');
    // Tour Routes

    Route::get('/admin/tours', [TourController::class, 'index'])->name('admin.tours.index');
    Route::get('/admin/tours/create', [TourController::class, 'create'])->name('admin.tours.create');
    Route::post('/admin/tours', [TourController::class, 'store'])->name('admin.tours.store');
    Route::get('/admin/tours/{tour}/edit', [TourController::class, 'edit'])->name('admin.tours.edit');
    Route::put('/admin/tours/{tour}', [TourController::class, 'update'])->name('admin.tours.update');
    Route::delete('/admin/tours/{tour}', [TourController::class, 'destroy'])->name('admin.tours.destroy');
    Route::get('/admin/tours/{tour}', [TourController::class, 'show'])->name('admin.tours.show');
    

  


});

    





