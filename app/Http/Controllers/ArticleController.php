<?php
// app/Http/Controllers/ArticleController.php
namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    // ✅ Your existing index method (keep it)
    public function index()
    {
        return Article::where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->get()
            ->map(fn($article) => [
                'id' => $article->id,
                'title' => $article->title,
                'image' => asset('storage/' . $article->image),
                'date' => $article->published_at->format('d F, Y'),
                'comments' => $article->comments_count . ' Comments',
                'link' => "/article-details/{$article->id}",
            ]);
    }

    // ✅ NEW: Get single article for details page
    public function show($id)
    {
        $article = Article::where('is_published', true)->findOrFail($id);

        return [
            'id' => $article->id,
            'title' => $article->title,
            'image' => asset('storage/' . $article->image),
            'date' => $article->published_at->format('d F, Y'),
            'author' => 'Admin', // You can add author field later
            'content' => $article->content, // Full HTML content from RichEditor
            'comments_count' => $article->comments_count,
            'excerpt' => $article->excerpt,
        ];
    }
}