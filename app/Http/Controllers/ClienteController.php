<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();

        $clienteComImagem = $clientes->map(function($clientes){
            return[
                'nome' => $clientes->nome,
                'endereco' => $clientes->endereco,
                'cpf' => $clientes-> cpf,
                'email' => $clientes-> email,
                'telefone' => $clientes-> telefone,
                'senha' => $clientes-> senha,
                'imagem' => asset('storage/' . $clientes->imagem)
            ];
        });
        return response()->json($clienteComImagem);
    }

    public function store(Request $request){

        $clienteData = $request->all();

        if($request->hasFile('imagem')){
            $imagem = $request->file('imagem');
            $nomeImagem = time().'.'.$imagem->getClientOriginalExtension();
            $caminhoImagem = $imagem->storeAs('imagens/cliente', $nomeImagem, 'public');
            $clienteData['imagem'] = $caminhoImagem;
        }

        $cliente = Cliente::create($clienteData);
        return response()->json(['cliente'=>$cliente],201);

    }
}
