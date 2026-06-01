<x-app-layout>
    <x-slot name="header">
        <h2>Meus Livros Favoritos</h2>
    </x-slot>

    <div style="padding: 30px;">
        <a href="{{ route('books.index') }}">Voltar para pesquisa</a>

        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        <hr>

        @forelse($favorites as $book)
            <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px;">
                @if($book->cover_url)
                    <img src="{{ $book->cover_url }}" width="100">
                @endif

                <h3>{{ $book->title }}</h3>
                <p><strong>Autor:</strong> {{ $book->author }}</p>
                <p><strong>Ano:</strong> {{ $book->first_publish_year }}</p>

                <form method="POST" action="{{ route('books.destroy', $book->id) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Remover</button>
                </form>
            </div>
        @empty
            <p>Nenhum livro favorito cadastrado.</p>
        @endforelse
    </div>
</x-app-layout>