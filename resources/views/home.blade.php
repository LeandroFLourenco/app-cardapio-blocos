@extends('layouts.app')

@section('title', 'Bem-vindo')

@section('content')
    <div class="text-center py-12">
        <h1 class="text-5xl font-bold text-gray-800 mb-4">🍔 Bem-vindo ao Cardápio</h1>
        
        <p class="text-xl text-gray-600 mb-8">
            Faça seu pedido de forma rápida e prática com nossa plataforma moderna.
        </p>

        <div class="flex gap-4 justify-center">
            <a href="{{ route('cardapio.index') }}" class="bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 px-8 rounded-lg transition transform hover:scale-105">
                Ver Cardápio
            </a>
            
            <a href="#" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-8 rounded-lg transition">
                Saiba Mais
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-16">
        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <div class="text-4xl mb-3">⚡</div>
            <h3 class="text-xl font-bold mb-2">Rápido</h3>
            <p class="text-gray-600">Faça seu pedido em poucos cliques</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <div class="text-4xl mb-3">🛡️</div>
            <h3 class="text-xl font-bold mb-2">Seguro</h3>
            <p class="text-gray-600">Seus dados estão sempre protegidos</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-md text-center">
            <div class="text-4xl mb-3">🚚</div>
            <h3 class="text-xl font-bold mb-2">Entrega</h3>
            <p class="text-gray-600">Receba seu pedido no conforto de casa</p>
        </div>
    </div>
@endsection
