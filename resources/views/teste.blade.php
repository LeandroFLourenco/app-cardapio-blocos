@extends('layouts.app')
@section('title', 'Testando Blade') <!-- muda o titulo da aba da página -->
@section('content')
    <h1>Cardápio</h1>
    <ul>
        @foreach($produtos as $produto)
            <li>{{ $produto }}</li>
        @endforeach
    </ul>
@endsection