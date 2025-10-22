<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin/login');
// Route::redirect()
// Route::get('/', [HomeController::class,'index']);
// Route::get('/{slug}', [HomeController::class,'view']);
