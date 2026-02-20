<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method')->nullable(); // pix, credito, debito, dinheiro
            $table->decimal('cash_value', 10, 2)->nullable(); // Valor do dinheiro (se usar)
            $table->decimal('change', 10, 2)->nullable(); // Troco a ser devolvido
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'cash_value', 'change']);
        });
    }
};
