<?php

use App\Http\Controllers\Api\V1\Book\BookController;
use App\Http\Controllers\Api\V1\Student\Auth\StudentAuthController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'student',
    'as' => 'student.',
], function () {
    Route::group([
        'prefix' => 'auth',
        'as' => 'auth.'
    ], function () {
        // Students auth endpoints
        Route::post('login', [StudentAuthController::class, 'login'])->name('login');
        Route::post('logout', [StudentAuthController::class, 'logout'])->name('logout')
            ->middleware(['auth:sanctum', 'student']);
    });

    Route::group([
        'middleware' => ['auth:sanctum', 'student']
    ], function () {
        // Students library endpoints
        Route::group([
            'prefix' => 'library',
            'as' => 'library.'
        ], function () {
            //Students books endpoint
            Route::apiResource('books', BookController::class)
                ->only(['index', 'show'])
                ->where(['book' => '[0-9]+']);
        });
    });
});
