<?php

use App\Http\Controllers\MetatraderController;
use App\Http\Controllers\StripeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/stripe/webhook', function (Request $request) {




    // Obtenha o payload e a assinatura do cabeçalho da solicitação
    // $payload = file_get_contents('json.json');
    $payload =$request->getContent();

    $stripe = new StripeController();
    $stripe->updateSubcription($payload);

});

Route::post('/metatrader/verify', [MetatraderController::class, 'verify']);

