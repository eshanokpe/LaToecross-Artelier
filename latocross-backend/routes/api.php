<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Api\ArtworkController;
use App\Http\Controllers\Api\FashionController;
use App\Http\Controllers\Api\SettingsController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

// Artworks
Route::get('/artworks', [ArtworkController::class, 'index']);
Route::get('/artworks/featured', [ArtworkController::class, 'featured']);
Route::get('/artworks/{id}', [ArtworkController::class, 'show']);
 
// Fashion
Route::get('/fashion', [FashionController::class, 'index']);
Route::get('/fashion/featured', [FashionController::class, 'featured']);
Route::get('/fashion/{id}', [FashionController::class, 'show']);

// Site Settings & Content
Route::get('/settings', [SettingsController::class, 'index']);

Route::post('/contact', [ContactController::class, 'store']);

Route::get('/articles', [ArticleController::class, 'index']);
Route::get('/articles/{slug}', [ArticleController::class, 'show']);