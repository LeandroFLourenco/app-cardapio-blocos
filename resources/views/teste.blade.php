@extends('layouts.app')
@section('title', 'Testando Blade') <!-- muda o titulo da aba da página -->
@section('content')
<h1 class="text-2xl font-bold">Cardápio</h1>
<div class="grid grid-cols-3 gap-6">

    @foreach($produtos as $produto)

        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-xl font-semibold">{{ $produto['nome'] }}</h2>

            <p class="text-orange-600 font-bold">R$ {{ $produto['preco'] }}</p>

            <button class="mt-3 bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600">Adicionar</button>
        </div>

    @endforeach

</div>

@endsection