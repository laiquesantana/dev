<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormularioVendas extends Model
{
    use SoftDeletes;

    protected $table = 'vendas';

    protected $primaryKey = 'id';

    protected $fillable = [
        'comprador', 'descricao', 'quantidade', 'endereco', 'fornecedor', 'preco_unitario'
    ];


    protected $dates = [
        'created_at', 'updated_at'
    ];

}
