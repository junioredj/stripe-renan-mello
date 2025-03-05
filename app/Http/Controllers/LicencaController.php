<?php

namespace App\Http\Controllers;

use App\Models\Licenca;
use App\Models\Vendas;
use Exception;
use Illuminate\Http\Request;

class LicencaController extends Controller
{
    public function show()
    {
        return view('index', ['user_ativos' => $this->getUserAtivos(), 'user_inativos' => $this->getUserInativos(), 'users' => $this->getAllUsers(), 'new_clientes'=>$this->getNewClientes(), 'saldo' => $this->getSaldoClienteAtivos()]);
    }

    public function getNewClientes()
    {
        $qtd = Vendas::all()->where('end', '>', date('Y-m-d'))->where('created_at', ">", date('Y-m-d'))->count();
        return $qtd;
    }
    public function getUserInativos()
    {
        $qtd = Vendas::all()->where('end', '<', date('Y-m-d'))->count();
        return $qtd;
    }

    public function getUserAtivos()
    {
        $qtd = Vendas::all()->where('end', '>', date('Y-m-d'))->count();
        return $qtd;
    }

    public function getSaldoClienteAtivos()
    {
        $qtd = Vendas::all()->where('end', '>', date('Y-m-d'))->sum("saldo");
        return $qtd;
    }

    public function getAllUsers()
    {
        $users = Vendas::paginate(20);
        return $users;
    }

    public function update(Request $request)
    {
        $registro = Vendas::all()->where('id', $request->id)->first();
        if($registro)
        {
            $licenca = new Vendas();
            $licenca = $registro;

            $licenca->name = $request->nome??"NaN";
            $licenca->account_mt5 = $request->conta??"Nan";
            $licenca->end = $request->expiracao??null;
            $licenca->email = $request->email??null;
            $licenca->save();

            return redirect()->back()->with('msg', "Sucesso ao atualizar usuário");
        }
        else
            return redirect()->back()->with('error', "Erro atualizar usuário");
    }


    public function delete($id)
    {
        try
        {
            $licenca=Vendas::find($id);
            $licenca->delete(); //returns true/false

            return redirect()->back()->with('msg', "Sucesso ao deletar usuário");
        }
        catch(Exception $erro)
        {
            return redirect()->back()->with('error', "Erro atualizar usuário");
        }
    }

    public function store(Request $request)
    {
        try
        {
            $licenca = new Vendas();

            $licenca->name = $request->nome;
            $licenca->id_transaction = "Manual";
            $licenca->created = now();
            $licenca->object = "Site";
            $licenca->amount = 0;
            $licenca->description = "Licenças cadastrada no site";
            $licenca->start = now();
            $licenca->account_mt5 = (string)($request->conta);
            $licenca->end = $request->expiracao;
            $licenca->email = $request->email??null;
            $licenca->save();
            return redirect()->back()->with('msg_cadastro', "Usuário cadastrado");
        }
        catch(Exception $erro)
        {
            return redirect()->back()->with('error_cadastro', "Erro cadastrar usuário");
        }
    }


}
