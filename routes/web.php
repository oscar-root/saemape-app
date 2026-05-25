<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DocumentController;

Route::view('/', 'welcome')->name('home');

Route::middleware(['auth', 'verified'])->group(function () {

    // REDIRECTION RÔLES (Match strict)
    Route::get('/dashboard', function () {
        return match (auth()->user()->role) {
            'admin'     => view('dashboards.admin'),
            'delegue'   => view('dashboards.delegue'),
            'agent'     => view('dashboards.agent'),
            'dipro'     => view('dashboards.dipro'),
            default     => view('dashboard'),
        };
    })->name('dashboard');

    Route::view('profile', 'profile')->name('profile.edit');

    // ZONE TÉLÉCHARGEMENTS PDF (DocumentController)
    Route::prefix('download')->name('download.')->group(function () {
        Route::get('/identification/{association}', [DocumentController::class, 'identification'])->name('identification');
        Route::get('/declaration/{declaration}', [DocumentController::class, 'declaration'])->name('declaration');
        Route::get('/recu/{declaration}', [DocumentController::class, 'receipt'])->name('receipt');
        Route::get('/rapport-recettes', [DocumentController::class, 'paymentReport'])->name('payment-report');
        Route::get('/rapport-strategique', [DocumentController::class, 'strategicReport'])->name('strategic-report');
    });

    // ZONE DÉLÉGUÉ
    Route::middleware(['role:delegue,admin'])->prefix('delegue')->name('delegue.')->group(function () {
        Route::get('/association/mon-entite', function () { return view('pages.delegue.create-association'); })->name('association.create');
        Route::get('/production/nouvelle', function () { return view('pages.delegue.declare-production'); })->name('production.create');
        Route::get('/mes-documents', function () { return view('pages.delegue.my-documents'); })->name('documents.index');
    });

    // ZONE AGENT
    Route::middleware(['role:agent,admin'])->prefix('gestion')->name('gestion.')->group(function () {
        Route::get('/associations', function () { return view('pages.gestion.associations-list'); })->name('associations.index');
        Route::get('/productions', function () { return view('pages.gestion.productions-list'); })->name('productions.index');
        Route::get('/paiements', function () { return view('pages.gestion.payments-list'); })->name('payments.index');
    });

    // ZONE DIRECTION (DIPRO)
    Route::middleware(['role:dipro,admin'])->prefix('direction')->name('dipro.')->group(function () {
        Route::get('/rapports', function () { return view('pages.dipro.rapports'); })->name('rapports');
        Route::get('/statistiques', function () { return view('pages.dipro.stats'); })->name('stats');
    });

    // ZONE ADMIN
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/utilisateurs', function () { return view('pages.admin.users-index'); })->name('users.index');
        Route::get('/maintenance', function () { return view('pages.admin.maintenance'); })->name('maintenance.index');
    });
});

require __DIR__.'/auth.php';