<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LuckyController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ManageLinkController;
use App\Http\Controllers\ResultsHistoryController;
use App\Http\Middleware\ValidateAccessToken;

Route::get('/', function () {
    return redirect()->route('register_form');
});

Route::get('/register', [RegisterController::class, 'index'])->name('register_form');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::group(['middleware' => ValidateAccessToken::class], function () {
    Route::get('/lucky/{access_token?}', [LuckyController::class, 'index'])
        ->where('access_token', '[a-zA-Z0-9]{100}')
        ->name('lucky_form');

    Route::post('/manage-link', [ManageLinkController::class, 'index'])->name('manage-link');
    Route::post('/luck-calculator', [LuckyController::class, 'calculate'])->name('luck-calculator');
    Route::post('/last-results', [ResultsHistoryController::class, 'lastResults'])->name('last-results');
});
