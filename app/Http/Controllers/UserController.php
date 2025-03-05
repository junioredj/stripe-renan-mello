<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vendas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use Stripe\Product;

class UserController extends Controller
{
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('login-view');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc|min:4|max:191',
            'password' => 'required|min:6|max:191',
            'passwdSame' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput($request->all());;
        }


        //Verifica se existe algum usuário com esse email
        $user = User::all()->where('email', $request->email)->first();
        if ($user != null) {
            return Redirect::back()->with('erro', "E-mail já cadastrado. Faça login para entrar");
        }


        $user = new User();

        $user->name = $request->name??"";
        $user->email = $request->email;
        $user->admin = 0;
        $user->password = bcrypt($request->password);
        $user->save();


        return redirect('/login')->with("message", "Sucesso ao realizar cadastro, faça login para entrar");
    }


    public function getLicencasClientes()
    {
        // Buscando as licenças do cliente no banco de dados
        $licencas = Vendas::where('email', Auth::user()->email)->get();

        // Inicializando o array que armazenará os produtos
        $produtos = [];

        // Configurando a chave secreta da API Stripe
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        // Buscando informações dos produtos no Stripe
        foreach ($licencas as $licenca) {
            // Tentando buscar o produto no Stripe
            try {
                // Recupera o produto baseado no ID da licença
                $produto = Product::retrieve($licenca->produto_id);
                // Armazenando as informações do produto no array
                $produtos[] = $produto;
            } catch (\Exception $e) {
                // Caso ocorra algum erro, você pode adicionar um valor null ou mensagem de erro
                $produtos[] = null;
            }
        }


        // Retorna diretamente os dados
        return ['licencas' => $licencas, 'produtos' => $produtos];
    }

    public function showSignup()
    {
        if(Auth::check())
            return to_route('licencas');

        return view('login.signup');
    }

    public function showLogin()
    {
        if(Auth::check())
            return to_route('licencas');

        return view('login.login');
    }

    public function login(Request $request)
    {




        $validator = Validator::make($request->all(), [
            'email' => 'required|email:rfc|min:4|max:191',
            'password' => 'required|min:6|max:191',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput($request->all());;
        }


        $credentials = [
            'email' => $request->email,
            'password' => ($request->password),
        ];


        if (Auth::attempt($credentials))
        {
            $registro = User::all()->where('email', $request->email)->first();

            if($registro->admin == "1")
                return to_route('dashboard');
            else
                return to_route('licencas');

        } else
            return Redirect::back()->with(['erro' => "E-mail ou senha inválidos"])->withInput($request->all());
    }

    public function showLicencas()
    {
        return view('user.licencas', ['licencas' => $this->getLicencasClientes()]);

    }

    public function resetSenha()
    {
        return view('reset-senha.reset-senha');
    }
}
