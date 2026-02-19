<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'nome' => 'Hambúrguer Artesanal',
            'descricao' => 'Pão brioche, carne 180g, queijo cheddar e molho especial.',
            'imagem' => 'https://via.placeholder.com/250x150?text=Hamburguer',
            'preco' => 35.00,
            'quantidade' => 50,
            'ativo' => true,
        ]);

        Product::create([
            'nome' => 'Pizza Calabresa',
            'descricao' => 'Molho especial, queijo derretido e calabresa.',
            'imagem' => 'https://via.placeholder.com/250x150?text=Pizza',
            'preco' => 45.00,
            'quantidade' => 30,
            'ativo' => true,
        ]);

        Product::create([
            'nome' => 'Batata Frita',
            'descricao' => 'Porção crocante com sal grosso.',
            'imagem' => 'https://via.placeholder.com/250x150?text=Batata',
            'preco' => 15.00,
            'quantidade' => 100,
            'ativo' => true,
        ]);

        Product::create([
            'nome' => 'Refrigerante 2L',
            'descricao' => 'Bebida gelada de 2 litros.',
            'imagem' => 'https://via.placeholder.com/250x150?text=Refrigerante',
            'preco' => 12.00,
            'quantidade' => 200,
            'ativo' => true,
        ]);

        Product::create([
            'nome' => 'Milkshake Chocolate',
            'descricao' => 'Milkshake cremoso de chocolate com calda.',
            'imagem' => 'https://via.placeholder.com/250x150?text=Milkshake',
            'preco' => 18.00,
            'quantidade' => 25,
            'ativo' => true,
        ]);
    }
}
