<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArticleManagementController extends Controller
{
    public function index(): View
    {
        $articles = Article::query()->latest('id')->paginate(15);

        return view('admin.articles.index', compact('articles'));
    }

    public function create(): View
    {
        return view('admin.articles.form', [
            'article' => new Article(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        unset($data['cover']);

        $data['slug'] = Article::uniqueSlugFrom($data['title']);

        if ($request->hasFile('cover')) {
            $data['cover_image'] = $this->storeCover($request);
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('status', 'Artikel berhasil dibuat.');
    }

    public function edit(Article $article): View
    {
        return view('admin.articles.form', compact('article'));
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $data = $this->validated($request);
        unset($data['cover']);

        if ($data['title'] !== $article->title) {
            $data['slug'] = Article::uniqueSlugFrom($data['title'], $article->id);
        }

        if ($request->hasFile('cover')) {
            $data['cover_image'] = $this->storeCover($request);
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('status', 'Artikel berhasil diperbarui.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()->route('admin.articles.index')->with('status', 'Artikel berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'excerpt' => ['nullable', 'string', 'max:300'],
            'body' => ['required', 'string'],
            'published_at' => ['nullable', 'date'],
            'cover' => ['nullable', 'image', 'max:4096'],
        ]);
    }

    private function storeCover(Request $request): string
    {
        $file = $request->file('cover');
        $filename = uniqid('article-').'.'.$file->extension();
        $file->move(public_path('images/articles'), $filename);

        return $filename;
    }
}
