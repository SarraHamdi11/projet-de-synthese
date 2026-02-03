<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\AnnonceController;
use App\Http\Controllers\admin\ReservationController;
use App\Http\Controllers\proprietaire\LogementpropController;
use App\Http\Controllers\proprietaire\AnnoncepropController;
use App\Http\Controllers\proprietaire\ReservationpropController;
use App\Http\Controllers\locataire\LogementlocaController;
use App\Http\Controllers\locataire\ReservationlocaController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\VisitorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route for the visitor page (root)
Route::get('/', [VisitorController::class, 'index'])->name('visitor');

// Simple fallback route for testing
Route::get('/welcome', function () {
    return response()->json([
        'message' => 'Welcome to StayFind!',
        'status' => 'working',
        'timestamp' => now()->toISOString()
    ]);
});

// Authentication routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignupForm'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password reset routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

// Home route
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Profile routes
Route::get('/profile', [UserProfileController::class, 'show'])->name('profile.show');
Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');

// Admin routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/listings', [AnnonceController::class, 'index'])->name('listings.index');
    Route::get('/listings/{id}', [AnnonceController::class, 'show'])->name('listings.show');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
});

// Proprietaire routes
Route::prefix('proprietaire')->name('proprietaire.')->middleware(['auth', 'role:proprietaire'])->group(function () {
    Route::get('/accueilproprietaire', [LogementpropController::class, 'index'])->name('accueilproprietaire');
    Route::get('/logements', [LogementpropController::class, 'logements'])->name('logements');
    Route::get('/add', [LogementpropController::class, 'create'])->name('add');
    Route::post('/store', [LogementpropController::class, 'store'])->name('store');
    Route::get('/edit/{id}', [LogementpropController::class, 'edit'])->name('edit');
    Route::put('/update/{id}', [LogementpropController::class, 'update'])->name('update');
    Route::delete('/delete/{id}', [LogementpropController::class, 'delete'])->name('delete');
    Route::get('/details/{id}', [LogementpropController::class, 'details'])->name('details');
    Route::get('/annonces', [AnnoncepropController::class, 'index'])->name('annonces.index');
    Route::get('/annonces/create/{logement_id}', [AnnoncepropController::class, 'create'])->name('annonces.create');
    Route::post('/annonces/store', [AnnoncepropController::class, 'store'])->name('annonces.store');
    Route::get('/reservations', [ReservationpropController::class, 'index'])->name('reservations.index');
});

// Locataire routes
Route::prefix('locataire')->name('locataire.')->middleware(['auth', 'role:locataire,colocataire'])->group(function () {
    Route::get('/accueillocataire', [LogementlocaController::class, 'index'])->name('accueillocataire');
    Route::get('/logementsloca', [LogementlocaController::class, 'logementsloca'])->name('logementsloca');
    Route::get('/showDetails/{id}', [LogementlocaController::class, 'showDetails'])->name('showDetails');
    Route::get('/reservations', [ReservationlocaController::class, 'index'])->name('reservations.index');
    Route::post('/reservations/store', [ReservationlocaController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/create/{annonce_id}', [ReservationlocaController::class, 'create'])->name('reservations.create');
});

// Message routes
Route::middleware('auth')->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');
    Route::get('/conversations/view/{id}', [MessageController::class, 'viewConversation'])->name('conversations.view');
    Route::post('/conversations/delete/{id}', [MessageController::class, 'deleteConversation'])->name('conversations.delete');
    Route::post('/messages/delete/{id}', [MessageController::class, 'deleteMessage'])->name('messages.delete');
});

// Notification routes
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/delete-all', [NotificationController::class, 'deleteAll'])->name('notifications.delete-all');
});
