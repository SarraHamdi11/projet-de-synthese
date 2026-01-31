<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\locataire\LogementlocaController;
use App\Http\Controllers\proprietaire\ProprietaireProfileController;
use App\Http\Controllers\proprietaire\LogementpropController;
use App\Http\Controllers\locataire\AccueilLocataireController;
use App\Http\Controllers\locataire\AnnonceLocataireController;
use App\Http\Controllers\locataire\LocataireProfileController;
use App\Http\Controllers\locataire\ReservationLocataireController;
use App\Http\Controllers\proprietaire\AccueilProprietaireController;
use App\Http\Controllers\proprietaire\AnnonceProprietaireController;
use App\Http\Controllers\proprietaire\ReservationProprietaireController;


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
    Route::get('/annonces', [AnnonceProprietaireController::class, 'index'])->name('annoncesproprietaire.index');
    Route::post('/annonces', [AnnonceProprietaireController::class, 'store'])->name('annoncesproprietaire.store');
    Route::get('/annonces/{id}/edit', [AnnonceProprietaireController::class, 'edit'])->name('modifierannonceproprietaire');
    Route::put('/annonces/{id}', [AnnonceProprietaireController::class, 'update'])->name('annoncesproprietaire.update');
    Route::delete('/annonces/{id}', [AnnonceProprietaireController::class, 'destroy'])->name('annoncesproprietaire.destroy');
 Route::get('/reservations', [ReservationProprietaireController::class, 'index'])->name('reservations.index');
    Route::post('/reservations/{id}/accepter', [ReservationProprietaireController::class, 'accepter'])->name('reservations.accepter');
    Route::post('/reservations/{id}/refuser', [ReservationProprietaireController::class, 'refuser'])->name('reservations.refuser');
    Route::get('/reservations/historique', [ReservationProprietaireController::class, 'historique'])->name('reservations.historique');
    
  


});

Route::prefix('locataire')->name('locataire.')->middleware('auth')->group(function () {
    Route::get('/accueillocataire', [AccueilLocataireController::class, 'index'])->name('accueillocataire');
    Route::get('/annonceslocataire', [AnnonceLocataireController::class, 'index'])->name('annonceslocataire.index');
    Route::post('/annonceslocataire', [AnnonceLocataireController::class, 'store'])->name('annoncelocataire.store');
    Route::get('/annonceslocataire/{id}/edit', [AnnonceLocataireController::class, 'edit'])->name('modifierannoncelocataire.edit');
    Route::put('/annonceslocataire/{id}', [AnnonceLocataireController::class, 'update'])->name('annoncelocataire.update');
    Route::delete('/annonceslocataire/{id}', [AnnonceLocataireController::class, 'destroy'])->name('annoncelocataire.destroy');
 Route::get('/reservations', [ReservationLocataireController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/{id}', [ReservationLocataireController::class, 'show'])->name('reservations.show');
    Route::post('/reservations/{id}/annuler', [ReservationLocataireController::class, 'annuler'])->name('reservations.annuler');
    Route::get('/reservations/historique', [ReservationLocataireController::class, 'historique'])->name('reservations.historique');
    Route::get('/reservations/{id}/edit', [ReservationLocataireController::class, 'edit'])->name('reservations.edit');
    Route::patch('/reservations/{id}', [ReservationLocataireController::class, 'update'])->name('reservations.update');
    

});


Route::prefix('admin')->middleware('auth')->group(function () {
    // Dashboard routes
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/get-recent-users', [AdminController::class, 'getRecentUsers'])->name('admin.getRecentUsers');
    Route::get('/get-recent-listings', [AdminController::class, 'getRecentListings'])->name('admin.getRecentListings');
    Route::get('/get-dashboard-stats', [AdminController::class, 'getDashboardStats'])->name('admin.getDashboardStats');

    // Users routes
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::delete('/users/{id}', [AdminController::class, 'deleteUser'])->name('admin.deleteUser');
    Route::get('/users/export', [AdminController::class, 'exportUsers'])->name('admin.users.export');

    // Listings routes (updated with new functionality)
    Route::get('/listings', [AdminController::class, 'listings'])->name('admin.listings');
    Route::delete('/listings/{id}', [AdminController::class, 'deleteListing'])->name('admin.deleteListing');
    Route::get('/listings/export', [AdminController::class, 'exportListings'])->name('admin.exportListings');
    Route::get('/listings/{id}/detail', [AdminController::class, 'showListingDetail'])->name('admin.showListingDetail');
});
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

    Route::post('/notifications/{id}/mark-read', function($id) {
        if (Auth::user()) {
            Auth::user()->notifications()->where('id', $id)->update(['read_at' => now()]);
        }
        return response()->json(['success' => true]);
    })->name('notifications.markRead');

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

Route::get('/profile/{user}', [UserProfileController::class, 'show'])->name('profile.show');
Route::get('/proprietaire/profile/{user}', [ProprietaireProfileController::class, 'index'])->name('proprietaire.profile');

Route::get('/proprietaire/logements', [LogementpropController::class, 'index'])->name('proprietaire.logements');
Route::get('/details/{id}', [LogementpropController::class, 'details'])->name('proprietaire.details');

Route::get('/locataire/logements', [LogementlocaController::class, 'indexLocataire'])->name('logementsloca');
Route::get('/locataire/details/{id}', [LogementlocaController::class, 'showDetails'])->name('showDetails');
Route::post('/locataire/details/{id}/comment', [LogementlocaController::class, 'storeComment'])->name('storeComment');

Route::get('/locataire/reservation/{id}', [LogementlocaController::class, 'showReservation'])->name('showReservation');
Route::post('/locataire/reservation', [LogementlocaController::class, 'storeReservation'])->name('storeReservation');

Route::post('/locataire/favorite/{id}', [LogementlocaController::class, 'toggleFavorite'])->name('favorite.toggle');
Route::get('/locataire/favorites', [LogementlocaController::class, 'showFavorites'])->name('locataire.favorites');

Route::get('/locataire/myprofile', [LocataireProfileController::class, 'myProfile'])->name('locataire.myprofile');
Route::get('/proprietaire/myprofile', [ProprietaireProfileController::class, 'myProfile'])->name('proprietaire.myprofile');
