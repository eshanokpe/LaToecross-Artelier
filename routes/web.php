<?php

use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/blog', [HomeController::class, 'blog'])->name('blog');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/artworks', [HomeController::class, 'contact'])->name('artwork.index');
Route::get('/artworks/show', [HomeController::class, 'contact'])->name('artwork.show');

// Dynamic Category Routes
Route::get('/category/{category:slug}', function (Category $category) {
    return view('category.show', ['category' => $category]);
})->name('category.show');

// Arkworks Routes
Route::prefix('arkworks')->name('arkworks.')->group(function () {
    Route::get('/paintings', function () {
        $category = Category::where('slug', 'original-paintings')->first();
        return view('arkworks.paintings', ['category' => $category]);
    })->name('paintings');
    
    Route::get('/wall-art', function () {
        $category = Category::where('slug', 'wall-art')->first();
        return view('arkworks.wall-art', ['category' => $category]);
    })->name('wall-art');
    
    Route::get('/new-arrivals', function () {
        $category = Category::where('slug', 'new-arrivals')->first();
        return view('arkworks.new-arrivals', ['category' => $category]);
    })->name('new-arrivals');
});

// Fashion Routes
Route::prefix('fashion')->name('fashion.')->group(function () {
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

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

Route::get('/support', function () {
    return view('support');
})->name('support');

Route::get('/terms', function () {
    return view('terms');
})->name('terms');

Route::get('/privacy', function () {
    return view('privacy');
})->name('privacy');