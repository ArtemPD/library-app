<?php

use App\Http\Controllers\Api\V1\Client\Book\ClientBookController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'client',
    'as' => 'client.',
], function () {

    // Client library endpoints
    Route::apiResource('books', ClientBookController::class)
        ->only(['index'])
        ->where(['book' => '[0-9]+']);
});
