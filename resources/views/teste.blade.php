@extends('layouts.app')
@section('title', 'Testando Blade') <!-- muda o titulo da aba da página -->
@section('content')
<h1 class="text-2xl font-bold">Cardápio</h1>
<p class="mb-4 font-bold">
    Itens no carrinho: <span id="contador-carrinho">0</span>
</p>

<p class="mb-4 font-bold">
Total: R$ <span id="total-carrinho">0</span>
</p>

<h2 class="text-lg font-semibold mt-6">Carrinho</h2>

<ul id="lista-carrinho" class="list-disc ml-6 mt-2">
</ul>

<p id="mensagem-produto" class="mb-4 text-green-600 font-semibold"></p>

<div class="grid grid-cols-3 gap-6">

    @foreach($produtos as $produto)

        <div class="bg-white shadow-md rounded-lg p-4">
            <h2 class="text-xl font-semibold">{{ $produto['nome'] }}</h2>

            <p class="text-orange-600 font-bold">R$ {{ $produto['preco'] }}</p>

            <button class="mt-3 bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600" onclick="adicionarProduto('{{ $produto['nome'] }}', {{ $produto['preco'] }})">
                Adicionar
            </button>
        </div>

    @endforeach

</div>

<script>
let totalItens = 0;
let carrinho = [];
let totalCarrinho = 0;

let carrinhoSalvo = localStorage.getItem("carrinho");

if (carrinhoSalvo) {
    carrinho = JSON.parse(carrinhoSalvo);
    totalItens = carrinho.length;

    document.getElementById("contador-carrinho").innerText = totalItens;
}

function adicionarProduto(nome, preco)
{
    totalItens++;
    carrinho.push(nome);
    localStorage.setItem("carrinho", JSON.stringify(carrinho));
    totalCarrinho += preco;

    document.getElementById("contador-carrinho").innerText = totalItens;
    document.getElementById("total-carrinho").innerText = totalCarrinho;

    let lista = document.getElementById("lista-carrinho");

    let item = document.createElement("li");

    item.innerText = nome + " - R$ " + preco;

    lista.appendChild(item);
    console.log("Carrinho:", carrinho);
    console.log("Produto:", nome);
    console.log("Preço:", preco);
    console.log("Total clicado:", totalItens);

    alert(
            "Você adicionou: " + nome +
            "\nPreço: R$ " + preco +
            "\nItens clicados: " + totalItens +
            "\nTotal do carrinho: R$ " + totalCarrinho
        );
}


// function adicionarProduto(nome, preco)
// {
//     alert("Produto: " + nome + " - Preço: R$ " + preco);
// }

</script>

@endsection