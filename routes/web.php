<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LicencaController;
use App\Http\Controllers\NewPasswordController;
use App\Http\Controllers\SenhaController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\UserController;
use App\Models\Licenca;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function()
{
    return view('construction');
});



// ROTAS DE AUTENTICAÇÃO
Route::get('/login', [UserController::class, 'showLogin'])->name('login-view');
Route::post('/login', [UserController::class, 'login'])->name('login');
Route::get('/signup', [UserController::class, 'showSignup'])->name('signup');
Route::post('/signup', [UserController::class, 'store'])->name('signup-verify');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');


// ROTAS DE RECUPERAÇÃO DE SENHA
Route::get('/recuperar-senha', [SenhaController::class, 'showForm'])->name('form-email-senha');
Route::post('send-token-senha', [SenhaController::class, 'sendEmailRecuperacaoSenha'])->name('token-senha');
Route::get('/reset-password', [UserController::class, 'resetSenha'])->name('redefinir-senha');
Route::post('/reset', [NewPasswordController::class, 'reset'])->name('reset-password');
Route::post('/forgot-password', [NewPasswordController::class, 'forgotPassword'])->name('esqueceu-senha');

// ROTAS DE ADMIN
Route::middleware('admin')->group(function()
{
    Route::get('/admin/licencas', [LicencaController::class, 'show'])->name('dashboard')->middleware('admin');
    Route::get('admin/delete/licenca/{id}', [LicencaController::class, 'delete']);
    Route::post('/register/user', [LicencaController::class, 'store'])->name('user.register');
    Route::post('/update/user', [LicencaController::class, 'update'])->name('user.update');
});

Route::get('/licencas', [UserController::class, 'showLicencas'])->name('licencas');
Route::post('update-account-mt5', [StripeController::class, 'updateAccountMt5'])->name('update.account');
Route::get('produto/{productId}', [StripeController::class, 'buscarProduto']);


