<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MarcaController extends Controller
{
    public function __construct(Marca $marca){
        $this->marca = $marca;
    }
    /**
     * Display a listing of the resource.
     *
     * @return Marca[]|Collection|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $marcas = array();

        if($request->has('atributos_modelos')) {
            $atributos_modelos = $request->atributos_modelos;
            $marcas = $this->marca->with('modelos:id,'.$atributos_modelos);
        } else {
            $marcas = $this->marca->with('modelos');
        }

        if($request->has('filtro')) {
            $filtros = explode(';', $request->filtro);
            foreach($filtros as $key => $condicao) {

                $c = explode(':', $condicao);
                $marcas = $marcas->where($c[0], $c[1], $c[2]);

            }
        }

        if($request->has('atributos')) {
            $atributos = $request->atributos;
            $marcas = $marcas->selectRaw($atributos)->get();
        } else {
            $marcas = $marcas->get();
        }

        return response()->json($marcas, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate($this->marca->rules(), $this->marca->feedback());

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens', 'public');

        $marca = $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $imagem_urn
        ]);
        return $marca;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Marca $marca
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Builder[]|Collection|\Illuminate\Database\Eloquent\Model|\Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $marca = $this->marca->with('modelos')->find($id);

        if ($marca === null) {
            return response()->json(['erro' => 'Marca não existe'], 404);
        } else {
            return $marca;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Marca $marca
     * @return Marca|\Illuminate\Http\JsonResponse|string[]
     */
    public function update(Request $request, $id)
    {
        $marca = $this->marca->find($id);
        if ($marca === null) {
            return response()->json(['erro' => 'Atualização não realizada, marca não existe'], 404);
        }

        if ($request->method() === "PATCH") {
            $regrasDinamicas = array();

            foreach ($marca->rules() as $input => $regra) {
                if (array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas, $marca->feedback());
        } else {
            $request->validate($marca->rules(), $marca->feedback());
        }

        if ($request->file('imagem')) {
            Storage::disk('public')->delete($marca->imagem);
        }

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens', 'public');

        $marca->fill($request->all());
        $marca->imagem = $imagem_urn;
        $marca->save();

        return $marca;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Marca $marca
     * @return \Illuminate\Http\JsonResponse|string[]
     */
    public function destroy($id)
    {
        $marca = $this->marca->find($id);

        if ($marca === null) {
            return response()->json(['erro' => 'Deleção não realizada, marca não existe'], 404);
        }

        Storage::disk('public')->delete($marca->imagem);


        $marca->delete();
        return ['msg' => 'Marca deletada com sucesso.'];
    }
}
