<?php

use App\Http\Controllers\ClientController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;

// Маршруты для клиента
Route::get('/', [ClientController::class, 'index'])->name('client.index');
Route::get('/hall/{id}', [ClientController::class, 'hall'])->name('client.hall');
Route::post('/booking/complete', [ClientController::class, 'completeBooking'])->name('client.complete_booking');
Route::get('/payment', [ClientController::class, 'payment'])->name('client.payment');
Route::post('/payment/complete', [ClientController::class, 'completePayment'])->name('client.complete_payment');
Route::get('/ticket/{sessionId}/{seatRow}/{seatNumber}', [ClientController::class, 'showTicket'])->name('client.ticket');

// Маршруты для авторизации
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Защищенные маршруты для админки (доступны только после авторизации)
Route::middleware('auth')->group(function () {
    // Главная страница админки
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    // Управление фильмами
Route::prefix('admin/movies')->name('admin.movies.')->group(function () {
    Route::get('/', [AdminController::class, 'movies'])->name('index');
    Route::get('/create', [AdminController::class, 'addMovieForm'])->name('create');
    Route::post('/store', [AdminController::class, 'storeMovie'])->name('store');

    // Используем MovieController для операций с фильмами
    Route::get('/{id}/edit', [MovieController::class, 'edit'])->name('edit');
    Route::put('/{movie}', [MovieController::class, 'update'])->name('update');
    Route::delete('/{id}', [MovieController::class, 'destroy'])->name('destroy');
});


    // Управление залами
    Route::prefix('admin/halls')->name('admin.halls.')->group(function () {
        Route::get('/', [AdminController::class, 'halls'])->name('index');
        Route::get('/create', [AdminController::class, 'createHallForm'])->name('create');
        Route::post('/store', [AdminController::class, 'storeHall'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'editHallForm'])->name('edit');
        Route::put('/{id}/update', [AdminController::class, 'updateHall'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'deleteHall'])->name('destroy');
        Route::post('/{id}/activate', [AdminController::class, 'activateHall'])->name('activate');
        Route::post('/{id}/deactivate', [AdminController::class, 'deactivateHall'])->name('deactivate'); 
    });
    

   // Управление сеансами
Route::prefix('admin/sessions')->name('admin.sessions.')->group(function () {
    Route::get('/', [AdminController::class, 'sessions'])->name('index');
    Route::get('/create', [AdminController::class, 'createSessionForm'])->name('create');
    Route::post('/store', [AdminController::class, 'storeSession'])->name('store');
    Route::get('/{id}/edit', [AdminController::class, 'editSessionForm'])->name('edit');
    Route::put('/{id}/update', [AdminController::class, 'updateSession'])->name('update');
    Route::delete('/{id}', [AdminController::class, 'deleteSession'])->name('destroy');
});


    // Управление ценами
    Route::prefix('admin/prices')->name('admin.prices.')->group(function () {
        Route::get('/', [AdminController::class, 'prices'])->name('index');
        Route::get('/create', [AdminController::class, 'createPriceForm'])->name('create');
        Route::post('/store', [AdminController::class, 'storePrice'])->name('store');
        Route::get('/{id}/edit', [AdminController::class, 'editPriceForm'])->name('edit');
        Route::post('/{id}/update', [AdminController::class, 'updatePrice'])->name('update');
        Route::delete('/{id}', [AdminController::class, 'deletePrice'])->name('destroy');
    });

    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
});
