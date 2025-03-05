<?php

namespace App\Http\Controllers;

use App\Models\Licenca;
use App\Models\Vendas;
use Illuminate\Http\Request;

class MetatraderController extends Controller
{
    public function verify(Request $request)
    {


        $request = json_decode(trim(file_get_contents('php://input')));

        $conta = $request->conta??"-1";



        $registro = Vendas::all()->where('account_mt5', $conta)->first();


        if($registro)
        {
            if($registro->end > date("Y-m-d"))
            {
                $registro->last_auth_mt5 = now();
                $registro->saldo = $request->saldo;
                $registro->moeda = $request->moeda;
                $registro->save();
                return array('licenca_ativa' => true, 'expiracao' => $registro->end, "saldo" => $request->saldo, "moeda: " => $request->moeda);
            }
            else
                return array('licenca_ativa' => false, 'expiracao' => $registro->end);
        }
        else
            return array('licenca_ativa' => false);

    }
}
