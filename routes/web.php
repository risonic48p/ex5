<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShortLinksController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/short/{hash}', [ShortLinksController::class, 'index'])->name('short.redirect')
->where('hash', '[a-f0-9]{32}');
