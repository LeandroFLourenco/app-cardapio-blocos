<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bloco extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'descricao',
    ];

    // Relacionamento com produtos (um bloco tem muitos produtos)
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}

