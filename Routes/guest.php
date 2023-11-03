<?php

use Illuminate\Support\Facades\Route;

/**
 * 'guest' middleware applied to all routes (including names)
 *
 * @see \App\Providers\Route::register
 */

Route::post('{company_id}/efi/webhook/{webhook_secret}',
    'Modules\Efi\Http\Controllers\Webhook@index')
    ->name('efi.invoices.webhook');
Route::post('{company_id}/efi/webhook/{webhook_secret}/pix',
    'Modules\Efi\Http\Controllers\Webhook@index')
    ->name('efi.invoices.webhook.pix');
