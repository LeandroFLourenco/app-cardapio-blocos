<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TesteController extends Controller
{
    public function index()
    {
        $produtos = [
            "Produto 1",
            "Produto 2",
            "Produto 3"
        ];
        return view('teste', compact('produtos'));
    }
}
