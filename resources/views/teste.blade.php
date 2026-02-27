@extends('layouts.app')
@section('title', 'Pagina Teste')
@section('content')
    <h1>Cardápio</h1>
    <ul>
        @foreach($produtos as $produto)
            <li>{{ $produto }}</li>
        @endforeach
    </ul>
@endsection