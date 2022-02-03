<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Repositories\ClienteRepository;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function __construct(Cliente $cliente)
    {
        $this->cliente = $cliente;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clienteRepository = new ClienteRepository($this->cliente);

        return response()->json($clienteRepository->getResultados(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->cliente->rules());

        $cliente = $this->cliente->create([
            'nome' => $request->nome
        ]);
        return $cliente;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Cliente $cliente
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = $this->cliente->find($id);

        if ($cliente === null) {
            return response()->json(['erro' => 'Carro não existe'], 404);
        } else {
            return $cliente;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateClienteRequest $request
     * @param \App\Models\Cliente $cliente
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cliente = $this->cliente->find($id);
        if ($cliente === null) {
            return response()->json(['erro' => 'Atualização não realizada, cliente não existe'], 404);
        }

        if ($request->method() === "PATCH") {
            $regrasDinamicas = array();

            foreach ($cliente->rules() as $input => $regra) {
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas);
        } else {
            $request->validate($cliente->rules());
        }

        $cliente->fill($request->all());
        $cliente->save();

        return $cliente;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Cliente $cliente
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response|string[]
     */
    public function destroy($id)
    {
        $cliente = $this->cliente->find($id);

        if ($cliente === null) {
            return response()->json(['erro' => 'Deleção não realizada, cliente não existe'], 404);
        }
        $cliente->delete();
        return ['msg' => 'Cliente deletada com sucesso.'];
    }
}
