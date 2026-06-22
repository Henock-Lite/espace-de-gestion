<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
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

// Auth
Route::get('/login', [SessionController::class, 'create'])->name('login');
Route::post('/login', [SessionController::class, 'store'])->name('login.store');
Route::post('/logout', [SessionController::class, 'destroy'])->name('logout');

// Admin
Route::middleware(['auth', 'admin'])->group(function () {

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

// Super Admin
Route::middleware(['auth', 'superadmin'])->group(function () {
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



Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::ResetLinkSent
        ? back()->with('success', 'Lien de réinitialisation envoyé.')
        : back()->withErrors(['email' => __($status)]);
})->name('password.email');

Route::get('/reset-password/{token}', function (string $token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

Route::post('/reset-password', function (Request $request) {
    $request->validate([
        'token'    => 'required',
        'email'    => 'required|email',
        'password' => 'required|min:8|confirmed',
    ]);

    $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function ($user, $password) {
            $user->update(['password' => Hash::make($password)]);
        }
    );

    return $status === Password::PasswordReset
        ? redirect()->route('login')->with('success', 'Mot de passe réinitialisé.')
        : back()->withErrors(['email' => __($status)]);
})->name('password.update');

