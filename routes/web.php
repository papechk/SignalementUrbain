<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\SignalementController;
use App\Http\Controllers\TerrainController;
use App\Http\Controllers\VitriController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes publiques (vitrine)
|--------------------------------------------------------------------------
*/
Route::get('/', [VitriController::class, 'accueil'])->name('accueil');

Route::get('/signalements', [VitriController::class, 'signalements'])->name('vitrine.signalements');
Route::get('/signalement/{signalement}', [VitriController::class, 'detail'])->name('vitrine.signalement.detail');

Route::get('/signaler', [VitriController::class, 'signaler'])->name('vitrine.signaler');
Route::post('/signaler', [VitriController::class, 'signalerStore'])->name('vitrine.signaler.store');

Route::get('/confirmation/{signalement}', [VitriController::class, 'confirmation'])->name('vitrine.confirmation');

Route::get('/suivi', [VitriController::class, 'suivi'])->name('vitrine.suivi');

Route::get('/contact', [VitriController::class, 'contact'])->name('vitrine.contact');
Route::post('/contact', [VitriController::class, 'contactStore'])->name('vitrine.contact.store');

/*
|--------------------------------------------------------------------------
| Demo Tailwind animations
|--------------------------------------------------------------------------
*/
Route::view('/animations-tailwind', 'dashboard.animations-tailwind')
    ->name('dashboard.animations.tailwind');

/*
|--------------------------------------------------------------------------
| Routes admin (back-office)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Signalements + categories
    Route::resource('signalements', SignalementController::class);
    Route::patch('signalements/{signalement}/statut', [SignalementController::class, 'changerStatut'])
        ->name('signalements.changerStatut');
    Route::resource('categories', CategorieController::class)->except(['show']);

    // Terrains
    Route::resource('terrains', TerrainController::class);

    // Reservations
    Route::get('reservations/calendar', [ReservationController::class, 'calendar'])->name('reservations.calendar');
    Route::get('reservations/events', [ReservationController::class, 'events'])->name('reservations.events');
    Route::patch('reservations/{reservation}/confirmer', [ReservationController::class, 'confirmer'])->name('reservations.confirmer');
    Route::patch('reservations/{reservation}/annuler', [ReservationController::class, 'annuler'])->name('reservations.annuler');
    Route::resource('reservations', ReservationController::class);

    // Paiements
    Route::patch('paiements/{paiement}/statut', [PaiementController::class, 'updateStatut'])->name('paiements.statut');
    Route::resource('paiements', PaiementController::class)->except(['show']);
});
