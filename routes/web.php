<?php

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Mail;
// use Illuminate\Support\Facades\Password;
// use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\FournisseurController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\LotController;
use App\Http\Controllers\MouvementStockController;
use App\Http\Controllers\ApprovisionnementController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\SuperAdminDashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\ForgotPasswordController;

// Auth
Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store'])->name('login.store');
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

// Admin (Protection Auth, Rôle Admin ET interdiction du bouton Retour)
Route::middleware(['auth', 'admin', 'prevent-back'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('categories', CategorieController::class);
    Route::resource('clients', ClientController::class);
    Route::resource('fournisseurs', FournisseurController::class);
    Route::resource('produits', ProduitController::class);
    Route::resource('lots', LotController::class);
    Route::resource('ventes', VenteController::class);
    Route::resource('approvisionnements', ApprovisionnementController::class);
    Route::resource('mouvements', MouvementStockController::class)->only(['index', 'show']);
});

// Super Admin (Protection Auth, Rôle SuperAdmin ET interdiction du bouton Retour)
Route::middleware(['auth', 'superadmin', 'prevent-back'])->group(function () {
    Route::get('/super', [SuperAdminDashboardController::class, 'index'])->name('super.dashboard');
    Route::resource('users', UserController::class);
});


Route::fallback(function () {
    if (!auth()->check()) {
        return redirect()->route('login');
    }
    
    // Rediriger selon le rôle
    return match(auth()->user()->role) {
        'super_admin' => redirect()->route('super.dashboard'),
        'admin'       => redirect()->route('dashboard'),
        default       => redirect()->route('login'),
    };
});

// Réinitialisation de mot de passe via le ForgotPasswordController
Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'reset'])->name('password.update');