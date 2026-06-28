<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FashionController;
use App\Http\Controllers\HomeController;

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

Route::get('/art-catalog', function () {
    return view('art-catalog');
})->name('art-catalog');

Route::get('/departments', function () {
    return view('departments');
})->name('departments');


Route::get('/how-to-bid', function () {
    return view('how-to-bid');
})->name('how-to-bid');

Route::get('/how-to-sell', function () {
    return view('how-to-sell');
})->name('how-to-sell');


Route::get('/faq', [HomeController::class, 'faq'])->name('faq');

Route::get('/support', function () {
    return view('support');
})->name('support');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');
