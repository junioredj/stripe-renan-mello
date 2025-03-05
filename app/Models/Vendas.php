<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vendas extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_transaction',
        'created',
        'object',//Usado para verificar qual é o evento que está sendo recebido
        'name',
        'email',
        'phone',
        'amount',//Valor da venda
        'description',
        'start',//ìnicio da licença
        'end',//Fim da licença
        'interval',
        'paid',
        'produto_id',
        'subscription',
        'account_mt5',
        'status',
        'last_auth_mt5',
        'descricao_licenca',
        'update_account',
        'saldo'

    ];
}
