<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'imagem'];
    /**
     * @var mixed
     */
    private $id;

    public function rules()
    {
        return [
            'nome' => 'required|unique:marcas|min:3',
            'imagem' => 'required|file|mimes:png'
        ];
    }

    public function feedback()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'imagem.mimes'=> 'O arquivo da imagem deve ser do tipo PNG',
            'nome.unique' => 'Marca já existe',
            'nome.min' => 'O nome deve ter no minimo 3 caracteres'
        ];
    }

    public function modelos()
    {
        //uma marca para vários modelos
        return $this->hasMany('App\Models\Modelo');
    }
}
