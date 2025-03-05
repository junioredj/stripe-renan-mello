<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class NewPasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {

        $request->validate([
            'email' => 'required|email',
        ]);

        $token = Str::random(64);

        $registros = DB::table('password_reset_tokens')
        ->select('email')
        ->whereRaw('email = ?', $request->email)->first();

        if($registros)
            return Redirect::back()->with('erro', "Já enviamos uma redefinição de senha no seu e-mail");



        try
        {
            $user = User::where('email', $request->email);

            if($user)
            {
                Mail::send('mail.forgotpassword', ['token' => $token], function($message) use ($request){
                    $message->to($request->email);
                    $message->subject('Redefinir senha');
                });

                DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'token' => $token,
                'created_at'=> Carbon::now()]);
            }

        }
        catch(Exception $ero)
        {

        }

        return Redirect::back()->with('message', "Caso seu e-mail exista será enviado as intruções para redefinir a senha no seu e-mail");

    }

    public function reset(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'password' => 'required|min:6|max:191',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator);
        }



        $email = DB::select('select email from password_reset_tokens where token = "'.$request->token.'" limit 1')[0]->email;


        $user = User::where('email', $email)->update(['password' => Hash::make( $request->password)]);

        DB::table('password_reset_tokens')->where('email', $email)->delete();

        return redirect()->to(route('login'))->with('message', "Senha alterada com sucesso");



    }
}
