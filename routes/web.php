<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\HomeController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::post('/cart/add', [HomeController::class, 'addToCart'])->name('cart.add');
Route::post('/cart/update', [HomeController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [HomeController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');
Route::post('/checkout', [HomeController::class, 'processCheckout'])->name('checkout.process');
Route::get('/checkout/success/{order}', [HomeController::class, 'success'])->name('checkout.success');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

Route::get('/login', [LoginController::class, 'show'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate'])->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

use App\Http\Controllers\StaffController;
use App\Http\Controllers\StaffMenuController;

Route::middleware(['auth', 'staff'])->prefix('staff')->name('staff.')->group(function () {
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('dashboard');
    Route::post('/order/{order}/advance', [StaffController::class, 'advanceStatus'])->name('order.advance');
    
    Route::get('/menus', [StaffMenuController::class, 'index'])->name('menus.index');
    Route::get('/menus/create', [StaffMenuController::class, 'create'])->name('menus.create');
    Route::post('/menus', [StaffMenuController::class, 'store'])->name('menus.store');
    Route::get('/menus/{menu}/edit', [StaffMenuController::class, 'edit'])->name('menus.edit');
    Route::put('/menus/{menu}', [StaffMenuController::class, 'update'])->name('menus.update');
    Route::patch('/menus/{menu}/toggle', [StaffMenuController::class, 'toggleActive'])->name('menus.toggle');
});

use App\Http\Controllers\OwnerDashboardController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\StaffAccountController;
use App\Http\Controllers\ReportController;

Route::middleware(['auth', 'owner'])->prefix('owner')->name('owner.')->group(function () {
    Route::get('/dashboard', [OwnerDashboardController::class, 'index'])->name('dashboard');
    
    // Expenses
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
    Route::get('/expenses/create', [ExpenseController::class, 'create'])->name('expenses.create');
    Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');

    // Staff Accounts
    Route::get('/staff', [StaffAccountController::class, 'index'])->name('staff.index');
    Route::get('/staff/create', [StaffAccountController::class, 'create'])->name('staff.create');
    Route::post('/staff', [StaffAccountController::class, 'store'])->name('staff.store');
    Route::patch('/staff/{user}/toggle', [StaffAccountController::class, 'toggleActive'])->name('staff.toggle');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
});
