<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class CardapioController extends Controller
{
    public function index()
    {
        $produtos = Product::where('ativo', true)->get();
        return view('cardapio', compact('produtos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'itens' => 'required|json',
            'observacoes' => 'nullable|string|max:500',
        ]);

        Order::create([
            'user_id' => auth()->id(),
            'itens' => json_decode($validated['itens']),
            'total' => $this->calcularTotal($validated['itens']),
            'status' => 'pendente',
            'observacoes' => $validated['observacoes'] ?? null,
        ]);

        return redirect('/')->with('success', 'Pedido realizado com sucesso!');
    }

    private function calcularTotal($itensJson)
    {
        $itens = json_decode($itensJson, true);
        $total = 0;

        foreach ($itens as $item) {
            $produto = Product::find($item['id']);
            if ($produto) {
                $total += $produto->preco * $item['quantidade'];
            }
        }

        return $total;
    }
}

