<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class MarcaController extends Controller
{
    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Collection|Marca[]
     */
    public function index()
    {
        return Marca::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $marca = Marca::create($request->all());
        return $marca;
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Marca $marca
     * @return string[]
     */
    public function show($id)
    {
        $marca = $this->marca->find($id);

        if ($marca === null) {
            return ['erro' => 'Marca não existe'];
        } else {
            return $marca;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Marca $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Marca $marca
     * @return Marca|string[]
     */
    public function update(Request $request, $id)
    {
        $marca = $this->marca->find($id);
        if ($marca === null) {
            return ['erro' => 'Atualização não realizada, marca não existe'];
        }
        $marca->update($request->all());
        return $marca;

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Marca $marca
     * @return string[]
     */
    public function destroy($id)
    {
        $marca = $this->marca->find($id);
        if ($marca === null) {
            return ['erro' => 'Deleção não realizada, marca não existe'];
        }
        $marca->delete();
        return ['msg' => 'Marca deletada com sucesso.'];
    }
}
