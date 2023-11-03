<?php

use Illuminate\Support\Facades\Route;

/**
 * 'signed' middleware and 'signed/efi' prefix applied to all routes (including names)
 *
 * @see \App\Providers\Route::register
 */

Route::signed('efi', function () {
    Route::get('invoices/{invoice}', 'Payment@show')->name('invoices.show');
});
