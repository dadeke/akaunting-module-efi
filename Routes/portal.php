<?php

use Illuminate\Support\Facades\Route;

/**
 * 'portal' middleware and 'portal/efi' prefix applied to all routes (including names)
 *
 * @see \App\Providers\Route::register
 */

Route::portal('efi', function () {
    Route::get('invoices/{invoice}', 'Payment@show')->name('invoices.show');
});
