<?php
// app/Http/Controllers/ArticleController.php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index()
    {
        return Article::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->get()
            ->map(fn($article) => [
                'id' => $article->id,
                'title' => $article->title,
                'slug' => $article->slug,
                'image' => $article->image,
                'date' => $article->published_at->format('d F, Y'),
                'comments' => $article->comments_count . ' Comments',
                'link' => "/article-details/{$article->id}",
            ]);
    }

    public function show($slug)
    {
        return Article::where('slug', $slug)->where('is_published', true)->firstOrFail();
    }
}