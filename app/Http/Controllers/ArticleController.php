<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::query()
            ->published()
            ->latest('published_at')
            ->paginate(9);

        return view('articles.index', [
            'articles' => $articles,
        ]);
    }

    public function show(Article $article): View
    {
        abort_unless($article->isPublished(), 404);

        $related = Article::query()
            ->published()
            ->where('id', '!=', $article->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('articles.show', [
            'article' => $article,
            'related' => $related,
            'title' => $article->title.' — MLUP Academy',
        ]);
    }
}
