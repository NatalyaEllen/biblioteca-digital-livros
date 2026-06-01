<x-app-layout>
    <x-slot name="header">
        <h2>Biblioteca Digital de Livros</h2>
    </x-slot>

    <div style="padding: 30px;">
        <form method="GET" action="{{ route('books.search') }}">
            <input type="text" name="q" placeholder="Digite o nome do livro" required>
            <button type="submit">Pesquisar</button>
        </form>

        <br>

        <a href="{{ route('books.favorites') }}">Ver meus favoritos</a>

        <hr>

        @isset($books)
            @foreach($books as $book)
                <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px;">
                    @if($book['cover_url'])
                        <img src="{{ $book['cover_url'] }}" width="100">
                    @endif

                    <h3>{{ $book['title'] }}</h3>
                    <p><strong>Autor:</strong> {{ $book['author'] }}</p>
                    <p><strong>Ano:</strong> {{ $book['first_publish_year'] }}</p>

                    <form method="POST" action="{{ route('books.store') }}">
                        @csrf
                        <input type="hidden" name="title" value="{{ $book['title'] }}">
                        <input type="hidden" name="author" value="{{ $book['author'] }}">
                        <input type="hidden" name="first_publish_year" value="{{ $book['first_publish_year'] }}">
                        <input type="hidden" name="cover_url" value="{{ $book['cover_url'] }}">
                        <input type="hidden" name="open_library_key" value="{{ $book['open_library_key'] }}">

                        <button type="submit">Salvar nos favoritos</button>
                    </form>
                </div>
            @endforeach
        @endisset
    </div>
</x-app-layout>