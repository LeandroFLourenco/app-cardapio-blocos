<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CardapioTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste: retorna página do cardápio
     */
    public function test_cardapio_page_returns_success()
    {
        Product::factory()->create(['ativo' => true]);
        
        $response = $this->get('/cardapio');
        
        $response->assertStatus(200);
        $response->assertViewIs('cardapio');
    }

    /**
     * Teste: cardápio mostra apenas produtos ativos
     */
    public function test_cardapio_shows_only_active_products()
    {
        Product::factory()->create(['ativo' => true, 'nome' => 'Produto Ativo']);
        Product::factory()->create(['ativo' => false, 'nome' => 'Produto Inativo']);
        
        $response = $this->get('/cardapio');
        $produtos = $response->viewData('produtos');
        
        $this->assertEquals(1, $produtos->count());
        $this->assertEquals('Produto Ativo', $produtos->first()->nome);
    }

    /**
     * Teste: página inicial retorna com sucesso
     */
    public function test_home_page_returns_success()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertViewIs('home');
    }

    /**
     * Teste: criar pedido com validação
     */
    public function test_create_order_validates_input()
    {
        $response = $this->post('/pedidos', [
            'itens' => 'invalid_json',
            'observacoes' => 'Alguma observação',
        ]);
        
        // Deve falhar validação
        $response->assertSessionHasErrors('itens');
    }

    /**
     * Teste: criar pedido com dados válidos
     */
    public function test_create_order_with_valid_data()
    {
        $product = Product::factory()->create(['preco' => 30.00]);
        
        $itens = json_encode([
            [
                'id' => $product->id,
                'nome' => $product->nome,
                'quantidade' => 2,
            ]
        ]);
        
        $response = $this->post('/pedidos', [
            'itens' => $itens,
            'observacoes' => 'Sem cebola',
        ]);
        
        // Verifica redirecionamento
        $response->assertRedirect('/');
    }

    /**
     * Teste: produto tem descrição e preço
     */
    public function test_product_has_required_attributes()
    {
        $product = Product::factory()->create([
            'nome' => 'Teste',
            'descricao' => 'Descrição do teste',
            'preco' => 25.00,
        ]);
        
        $this->assertNotNull($product->nome);
        $this->assertNotNull($product->descricao);
        $this->assertNotNull($product->preco);
        $this->assertEquals(25.00, $product->preco);
    }

    /**
     * Teste: observações com limite de caracteres
     */
    public function test_observacoes_max_characters()
    {
        $product = Product::factory()->create();
        
        $observacoes = str_repeat('a', 501);
        
        $itens = json_encode([
            ['id' => $product->id, 'nome' => $product->nome, 'quantidade' => 1]
        ]);
        
        $response = $this->post('/pedidos', [
            'itens' => $itens,
            'observacoes' => $observacoes,
        ]);
        
        $response->assertSessionHasErrors('observacoes');
    }
}
