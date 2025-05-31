<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\proprietaire\AccueilProprietaireController;
use App\Http\Controllers\locataire\AccueilLocataireController;
use App\Http\Controllers\proprietaire\annonceproprietaireController;
use App\Http\Controllers\locataire\AnnonceLocataireController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Proprietaire\ProfilPropController;
use App\Http\Controllers\Proprietaire\LogementpropController;
use App\Http\Controllers\Locataire\LogementlocaController;
use App\Http\Controllers\FavoriController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\NotificationsController;
use Illuminate\Support\Facades\Auth;
// auth
Route::get('/', [AuthController::class, 'visitor'])->name('visitor');
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/signup', [AuthController::class, 'showSignup'])->name('signup');
Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('reset-password.show');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');

Route::prefix('proprietaire')->name('proprietaire.')->middleware('auth')->group(function () {
    Route::get('/accueilproprietaire', [AccueilProprietaireController::class, 'index'])->name('accueilproprietaire');
    Route::get('/annonces', [annonceproprietaireController::class, 'index'])->name('annoncesproprietaire.index');
    Route::post('/annonces', [annonceproprietaireController::class, 'store'])->name('annoncesproprietaire.store');
    Route::get('/annonces/{id}/edit', [annonceproprietaireController::class, 'edit'])->name('modifierannonceproprietaire');
    Route::put('/annonces/{id}', [annonceproprietaireController::class, 'update'])->name('annoncesproprietaire.update');
    Route::delete('/annonces/{id}', [annonceproprietaireController::class, 'destroy'])->name('annoncesproprietaire.destroy');
});

Route::prefix('locataire')->name('locataire.')->middleware('auth')->group(function () {
    Route::get('/accueillocataire', [AccueilLocataireController::class, 'index'])->name('accueillocataire');
    Route::get('/annonceslocataire', [AnnonceLocataireController::class, 'index'])->name('annonceslocataire.index');
    Route::post('/annonceslocataire', [AnnonceLocataireController::class, 'store'])->name('annoncelocataire.store');
    Route::get('/annonceslocataire/{id}/edit', [AnnonceLocataireController::class, 'edit'])->name('modifierannoncelocataire.edit');
    Route::put('/annonceslocataire/{id}', [AnnonceLocataireController::class, 'update'])->name('annoncelocataire.update');
    Route::delete('/annonceslocataire/{id}', [AnnonceLocataireController::class, 'destroy'])->name('annoncelocataire.destroy');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth')->name('admin.dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::get('/messages/{receiverId}', [MessageController::class, 'show'])->name('messages.show');
    Route::get('/messages/{receiverId}/fetch', [MessageController::class, 'fetch'])->name('messages.fetch');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::post('/messages/{message}/delete', [MessageController::class, 'delete'])->name('messages.delete');
    Route::post('/messages/{message}/read', [MessageController::class, 'markAsRead'])->name('messages.read');
    Route::post('/messages/send', [MessageController::class, 'send'])->name('messages.send');

    Route::get('/conversations', [ConversationController::class, 'index'])->name('conversations.index');
    Route::get('/conversations/{proprietaireId}', [ConversationController::class, 'showOrCreate'])->name('conversations.show');
    Route::get('/conversations/view/{id}', [ConversationController::class, 'view'])->name('conversations.view');
    Route::post('/conversations/{id}/delete', [ConversationController::class, 'delete'])->name('conversations.delete');

    Route::post('/upload', [FileUploadController::class, 'upload'])->name('upload');

    Route::get('/notifications/unread-count', function() {
        return Auth::user() ? Auth::user()->notifications()->whereNull('read_at')->count() : 0;
    })->name('notifications.unreadCount');

    Route::get('/notifications', function() {
        return view('notifications.index', [
            'notifications' => optional(Auth::user())->notifications
        ]);
    })->name('notifications.index');

    Route::post('/notifications/mark-all-read', function() {
        if (Auth::user()) {
            Auth::user()->notifications()->whereNull('read_at')->update(['read_at' => now()]);
        }
        return response()->json(['success' => true]);
    })->name('notifications.markAllRead');

    Route::post('/notifications/delete-all', function() {
        if (Auth::user()) {
            Auth::user()->notifications()->delete();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 403);
    })->name('notifications.deleteAll');

    Route::get('/profile/edit', [UserProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [UserProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [UserProfileController::class, 'showPasswordForm'])->name('profile.password.form');
    Route::put('/profile/password', [UserProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/profile/delete', [UserProfileController::class, 'showDeleteForm'])->name('profile.delete.form');
    Route::delete('/profile', [UserProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/settings', function() {
        return view('settings.index');
    })->name('settings');
});

Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/proprietaire/profile/{user}', [ProfilPropController::class, 'index'])->name('proprietaire.profile');

Route::get('/proprietaire/logements', [LogementpropController::class, 'index'])->name('proprietaire.logements');
Route::get('/details/{id}', [LogementpropController::class, 'details'])->name('proprietaire.details');

Route::get('/locataire/logements', [LogementlocaController::class, 'indexLocataire'])->name('logementsloca');
Route::get('/locataire/details/{id}', [LogementlocaController::class, 'showDetails'])->name('showDetails');
Route::post('/locataire/details/{id}/comment', [LogementlocaController::class, 'storeComment'])->name('storeComment');

Route::get('/locataire/reservation/{id}', [LogementlocaController::class, 'showReservation'])->name('showReservation');
Route::post('/locataire/reservation', [LogementlocaController::class, 'storeReservation'])->name('storeReservation');

Route::post('/locataire/favorite/{id}', [LogementlocaController::class, 'toggleFavorite'])->name('favorite.toggle');
Route::get('/locataire/favorites', [LogementlocaController::class, 'showFavorites'])->name('locataire.favorites');
Route::post('/toggle-favorite/{logement}', [FavoriController::class, 'toggle'])->name('toggle.favorite');
