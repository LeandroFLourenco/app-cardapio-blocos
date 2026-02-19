<?php

namespace Tests\Unit;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Teste: criar produto com factory
     */
    public function test_product_factory_creates_valid_product()
    {
        $product = Product::factory()->create();
        
        $this->assertNotNull($product->id);
        $this->assertNotNull($product->nome);
        $this->assertNotNull($product->preco);
        $this->assertTrue($product->ativo);
    }

    /**
     * Teste: produto pode ser inativado
     */
    public function test_product_can_be_deactivated()
    {
        $product = Product::factory()->create(['ativo' => true]);
        
        $product->update(['ativo' => false]);
        
        $this->assertFalse($product->ativo);
    }

    /**
     * Teste: preço é convertido para decimal
     */
    public function test_product_price_is_decimal()
    {
        $product = Product::factory()->create(['preco' => 19.99]);
        
        $this->assertEquals('19.99', $product->preco);
    }

    /**
     * Teste: quantidade padrão é zero
     */
    public function test_product_default_quantity_is_zero()
    {
        $product = Product::factory()->create(['quantidade' => 0]);
        
        $this->assertEquals(0, $product->quantidade);
    }

    /**
     * Teste: fillable protege contra mass assignment
     */
    public function test_product_fillable_attributes()
    {
        $fillable = (new Product())->getFillable();
        
        $this->assertContains('nome', $fillable);
        $this->assertContains('preco', $fillable);
        $this->assertContains('ativo', $fillable);
    }

    /**
     * Teste: buscar produtos ativos
     */
    public function test_query_active_products()
    {
        Product::factory()->count(5)->create(['ativo' => true]);
        Product::factory()->count(3)->create(['ativo' => false]);
        
        $active = Product::where('ativo', true)->get();
        
        $this->assertEquals(5, $active->count());
    }
}
