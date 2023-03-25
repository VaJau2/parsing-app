<?php

use App\Http\Controllers\AuctionsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::get('/auctions', [AuctionsController::class, 'get'])->name('GetAuction');
