<?php

namespace App\Http\Controllers;

use App\Models\Vendas;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Stripe\Checkout\Session;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Stripe\Product;

class StripeController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function checkout()
    {

        return Redirect::to('https://buy.stripe.com/7sI7tJ37ydY5f8Q14a');
    }

    public function checkoutAnual()
    {

        return Redirect::to('https://buy.stripe.com/4gw8xN9vW3jraSA28f');
    }

    public function success()
    {
        return view('payment.success');
    }

    public function updateSubcription($evento)
    {
        //$evento = file_get_contents(public_path('json.json'));
        $subscription_data = json_decode($evento);




        if ($subscription_data->type == "invoice.paid") //Realiza a inscrição do cliente
        {
            // Extrai os dados relevantes da assinatura
            $id = $subscription_data->id;
            $created = date("Y-m-d H:i:s", $subscription_data->created);
            $subscription_id = $subscription_data->data->object->lines->data[0]->invoice;
            $object_type = $subscription_data->data->object->object;
            $customer_email = $subscription_data->data->object->customer_email;
            $customer_name = $subscription_data->data->object->customer_name;
            $customer_phone = $subscription_data->data->object->customer_phone;
            $amount = $subscription_data->data->object->lines->data[0]->amount;
            $description = $subscription_data->data->object->lines->data[0]->description;
            $start_date = date("Y-m-d H:i:s", $subscription_data->data->object->lines->data[0]->period->start);
            $end_date = date("Y-m-d H:i:s", $subscription_data->data->object->lines->data[0]->period->end);
            $interval = $subscription_data->data->object->lines->data[0]->plan->interval ?? "";
            $paid = $subscription_data->data->object->paid;
            $produto_id = $subscription_data->data->object->lines->data[0]->plan->product;
            $subscription = $subscription_data->data->object->subscription;

            if ($object_type == "invoice" && $paid) {
                // Busca o registro existente
                $existingRecord = Vendas::where('subscription', $subscription)->first();

                Vendas::updateOrCreate(
                    ['subscription' => $subscription], // Condição para encontrar o registro
                    [
                        'created' => $created,
                        'object' => $object_type,
                        'name' => $customer_name,
                        'email' => $customer_email,
                        'phone' => $customer_phone,
                        'amount' => $amount / 100,
                        'description' => $description,
                        'start' => $start_date,
                        'end' => $end_date,
                        'produto_id' => $produto_id,
                        'interval' => $interval,
                        'paid' => $paid,
                        'id_transaction' => $subscription_id,
                        'account_mt5' => $existingRecord ? $existingRecord->account_mt5 : 0,
                        'status' => 'paid',
                        'saldo' => $existingRecord ? $existingRecord->saldo : 0,
                    ]
                );
            }
        } else if ($subscription_data->type == "charge.refunded") //Cancela a inscrição do cliente
        {
            if ($subscription_data->data->object->refunded == true || $subscription_data->data->object->refunded == 1) {
                $id_transaction = $subscription_data->data->object->invoice;
                Vendas::where('id_transaction', $id_transaction)->update(
                    [
                        'end' => date('Y-m-d H:i:s'),
                        'status' => 'refunded',
                    ]
                );
            }
        }
    }

    public function updateAccountMt5(Request $request)
    {
        try {
            $venda = Vendas::where('email', Auth::user()->email)->where('id', $request->id_update)->first();


            $venda->account_mt5 = $request->conta;
            $venda->descricao_licenca = $request->nome;
            $venda->update_account = now();
            $venda->save();

            return Redirect::back()->with('msg', "Conta atualizada com sucesso!");
        } catch (Exception) {
            return Redirect::back()->with('error', "Erro ao atualizar os dados da conta, entre em contato com o suporte");
        }
    }

    public function buscarProduto($productId)
    {
        // Configure a chave secreta da API
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        try {
            // Busque o produto no Stripe usando a ID
            $produto = Product::retrieve($productId);

            return $produto->images[0];

            return response()->json($produto);
        } catch (Exception $e) {
            return 'https://upload.wikimedia.org/wikipedia/commons/thumb/3/3f/Placeholder_view_vector.svg/1280px-Placeholder_view_vector.svg.png';
        }
    }
}
