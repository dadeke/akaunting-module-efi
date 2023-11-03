<?php

use Illuminate\Support\Facades\Route;

Route::admin('efi', function () {
    Route::group(['prefix' => 'settings', 'as' => 'settings.'], function () {
        Route::get('/', 'Settings@edit')
            ->defaults('alias', 'efi')
            ->name('edit');
        Route::patch('/', 'Settings@update')
            ->defaults('alias', 'efi')
            ->name('update');
    });

    Route::resource('transactions', 'Transactions');
    Route::resource('logs', 'Logs');
});
