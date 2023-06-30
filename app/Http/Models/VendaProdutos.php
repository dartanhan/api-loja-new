<?php
namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class VendaProdutos extends Model
{
    public $table = 'loja_vendas_produtos';
    public $timestamps = false;
    protected $fillable = ['venda_id','codigo_produto','descricao','valor_produto','quantidade','categoria_id','fornecedor_id'];

    public function vendas() {
        return $this->belongsTo('App\Http\Models\Vendas');
    }

    function productsSales() {
        return  $this->hasMany(ProdutoVariation::class,'subcodigo', 'codigo_produto');
    }
}
