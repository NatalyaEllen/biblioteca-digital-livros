<?php

namespace App\Http\Controllers;

use App\Models\FavoriteBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    public function index()
    {
        return view('books.index');
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2'
        ]);

        $response = Http::get('https://openlibrary.org/search.json', [
            'q' => $request->q
        ]);

        $books = collect($response->json('docs'))->take(10)->map(function ($book) {
            $coverId = $book['cover_i'] ?? null;

            return [
                'title' => $book['title'] ?? 'Título não informado',
                'author' => $book['author_name'][0] ?? 'Autor não informado',
                'first_publish_year' => $book['first_publish_year'] ?? 'Ano não informado',
                'cover_url' => $coverId ? "https://covers.openlibrary.org/b/id/{$coverId}-M.jpg" : null,
                'open_library_key' => $book['key'] ?? null,
            ];
        });

        return view('books.index', compact('books'));
    }

    public function store(Request $request)
    {
        FavoriteBook::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'author' => $request->author,
            'first_publish_year' => $request->first_publish_year,
            'cover_url' => $request->cover_url,
            'open_library_key' => $request->open_library_key,
        ]);

        return redirect()->route('books.favorites')->with('success', 'Livro salvo nos favoritos!');
    }

    public function favorites()
    {
        $favorites = FavoriteBook::where('user_id', Auth::id())->latest()->get();

        return view('books.favorites', compact('favorites'));
    }

    public function destroy(FavoriteBook $favoriteBook)
    {
        if ($favoriteBook->user_id !== Auth::id()) {
            abort(403);
        }

        $favoriteBook->delete();

        return redirect()->route('books.favorites')->with('success', 'Livro removido dos favoritos!');
    }
}