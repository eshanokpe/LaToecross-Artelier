<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FashionController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Storage;

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::redirect('/admin/dashboard', '/admin')->name('admin.dashboard.redirect');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/article-details/{slug}', [HomeController::class, 'articleShow'])->name('article.show');

Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/artworks/{id}', [HomeController::class, 'artworkShow'])->name('artwork.show');

Route::get('/fashions', [FashionController::class, 'index'])->name('fashions.index');
Route::get('/fashions/{id}', [FashionController::class, 'show'])->name('fashion.show');
Route::get('/fashions/category/{category}', [FashionController::class, 'byCategory'])->name('fashions.category');

// Dynamic Category Routes
Route::get('/category/{category:slug}', function (Category $category) {
    return view('category.show', ['category' => $category]);
})->name('category.show');
 
// Arkworks Routes
Route::prefix('arkworks')->name('artworks.')->group(function () {
   Route::get('/', [HomeController::class, 'artworks'])->name('index');
   Route::get('/abstract', [HomeController::class, 'contact'])->name('abstract.paintings');
   Route::get('/landscape', [HomeController::class, 'contact'])->name('landscape.paintings');
   Route::get('/mixed-media', [HomeController::class, 'contact'])->name('mixed-media.paintings');
   Route::get('/figure', [HomeController::class, 'contact'])->name('figure.paintings');
   Route::get('/miniature', [HomeController::class, 'contact'])->name('miniature.paintings');
});

// Fashion Routes
Route::prefix('fashions')->name('fashion.')->group(function () {
    Route::get('/art-wear', function () {
        $category = Category::where('slug', 'art-you-wear')->first();
        return view('fashion.art-wear', ['category' => $category]);
    })->name('art-wear');
    
    Route::get('/bold-designs', function () {
        $category = Category::where('slug', 'bold-designs')->first();
        return view('fashion.bold-designs', ['category' => $category]);
    })->name('bold-designs');
    
    Route::get('/new-designs', function () {
        $category = Category::where('slug', 'new-designs')->first();
        return view('fashion.new-designs', ['category' => $category]);
    })->name('new-designs');
});

// Footer Routes
Route::get('/artists-portfolio', function () {
    return view('artists-portfolio');
})->name('artists-portfolio');





Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/support', [HomeController::class, 'support'])->name('support');
Route::post('/support/submit', [HomeController::class, 'submitSupport'])->name('support.submit');


Route::get('/storage/{path}', function ($path) {
    $disk = Storage::disk('public');
    if (! $disk->exists($path)) {
        abort(404);
    }
    return response($disk->get($path))
        ->header('Content-Type', $disk->mimeType($path));
})->where('path', '.*');

Route::post('/whatsapp-chat', [WhatsAppChatController::class, 'store']);

Route::get('/clear-cache', function() {
    Artisan::call('optimize:clear');
    return "Cache cleared!";
});