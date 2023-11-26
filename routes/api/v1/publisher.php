<?php

use App\Http\Controllers\Api\V1\Publisher\Auth\PublisherAuthController;
use App\Http\Controllers\Api\V1\Publisher\Book\PublisherBookController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'publisher',
    'as' => 'publisher.',
], function () {
    Route::group([
        'prefix' => 'auth',
        'as' => 'auth.'
    ], function () {

        // Publisher auth endpoints
        Route::post('login', [PublisherAuthController::class, 'login'])->name('login');
        Route::post('logout', [PublisherAuthController::class, 'logout'])->name('logout')
            ->middleware(['auth:sanctum', 'publisher']);
    });

    Route::group([
        'middleware' => ['auth:sanctum', 'publisher']
    ], function () {

        // Publisher library endpoints
        Route::group([
            'prefix' => 'library',
            'as' => 'library.'
        ], function () {

            // Publisher books endpoint
            Route::apiResource('books', PublisherBookController::class)->where(['book' => '[0-9]+']);
        });
    });
});
