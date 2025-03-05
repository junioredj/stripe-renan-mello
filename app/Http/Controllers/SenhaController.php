<?php

namespace App\Http\Controllers;

use App\Models\Vendas;
use Illuminate\Http\Request;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\Password;

class SenhaController extends Controller
{
    public function showForm()
    {
        return view('password.form-forget-password');
    }

    public function sendEmailRecuperacaoSenha(Request $request)
    {

        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));

        print_r($status);

    // Retorna a resposta com base no status
    return $status === Password::RESET_LINK_SENT
        ? back()->with('status', __($status))
        : back()->withErrors(['email' => __($status)]);
    }
}
