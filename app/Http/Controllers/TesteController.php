<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TesteController extends Controller
{
    public function index()
    {
        $produtos = [
            [
                'nome' => 'Produto 1',
                'preco' => 10.00,
            ],
            [
                'nome' => 'Produto 2',
                'preco' => 20.00,
            ],
            [
                'nome' => 'Produto 3',
                'preco' => 30.00,
            ]
        ];
        return view('teste', compact('produtos'));
    }
}
