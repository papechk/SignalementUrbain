<?php

use App\Http\Controllers\CategorieController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SignalementController;
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

Route::get('/signaler', [VitriController::class, 'signaler'])->middleware('auth')->name('vitrine.signaler');
Route::post('/signaler', [VitriController::class, 'signalerStore'])->middleware('auth')->name('vitrine.signaler.store');

Route::get('/confirmation/{signalement}', [VitriController::class, 'confirmation'])->name('vitrine.confirmation');

Route::get('/suivi', [VitriController::class, 'suivi'])->name('vitrine.suivi');

Route::get('/contact', [VitriController::class, 'contact'])->name('vitrine.contact');
Route::post('/contact', [VitriController::class, 'contactStore'])->name('vitrine.contact.store');

Route::get('/carte', [VitriController::class, 'carte'])->name('vitrine.carte');

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
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Signalements + categories
    Route::resource('signalements', SignalementController::class);
    Route::patch('signalements/{signalement}/statut', [SignalementController::class, 'changerStatut'])
        ->name('signalements.changerStatut');
    Route::resource('categories', CategorieController::class)->except(['show'])->parameters(['categories' => 'categorie']);


});

require __DIR__.'/auth.php';
