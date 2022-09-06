<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', function(Request $request){
    if(Auth::attempt(['email'=>$request->email, 'password'=>$request->password])){
        $user = Auth::user();
        $token = $user->createToken('JWT');
        
        return response()->json($token->plainTextToken, 200);
    }

    return response()->json('Usuario Invalido', 401);
});


Route::post('/run_migrations', function(Request $request) {

    if($request->user === $_ENV['USR_EXEC_SUPORT'] && $request->password === $_ENV['PASS_EXEC_MIGRATION']){
        try {
            Artisan::call('migrate', ["--force" => true ]);
            return response()->json("Artisan migration em execução", 200);
        } catch (Exception $e){
            return response()->json("Falha em chamar o artisan. <br> Mensagem de Erro: " . $e->getMessage(), 200);
        }
    }else{
        return response()->json("Falha nas credenciais " . $request->user . $request->password, 401);
    }
});


Route::post('/run_seeds', function(Request $request) {

    if($request->user === $_ENV['USR_EXEC_SUPORT'] && $request->password === $_ENV['PASS_EXEC_SEED']){
        try {
            Artisan::call('db:seed');
            return response()->json("Artisan seeds em execução", 200);
        } catch (Exception $e){
            return response()->json("Falha em chamar o artisan. <br> Mensagem de Erro: " . $e->getMessage(), 200);
        }
    }else{
        return response()->json("Falha nas credenciais " . $request->user . $request->password, 401);
    }
});

Route::post('/run_composer', function(Request $request) {

    if($request->user === $_ENV['USR_EXEC_SUPORT'] && $request->password === $_ENV['PASS_EXEC_COMPOSER']){
        try {
            shell_exec('composer update');
            return response()->json("Composer em execução", 200);
        } catch (Exception $e){
            return response()->json("Falha em chamar o composer. <br> Mensagem de Erro: " . $e->getMessage(), 200);
        }
    }else{
        return response()->json("Falha nas credenciais " . $request->user . $request->password, 401);
    }
});


Route::post('/run_teste', function(Request $request) {

    if($request->user === $_ENV['USR_EXEC_SUPORT'] && $request->password === $_ENV['PASS_EXEC_TESTE_ENV']){
        return response()->json("Chamada Teste Ok!", 200);
    }else{
        return response()->json("Falha nas credenciais <br> Enviado: " . $request->user . " -- " . $request->password . "<br> Env:" .$_ENV['USR_EXEC_SUPORT'] . " -- " . $_ENV['PASS_EXEC_TESTE_ENV'], 401);
    }
});
