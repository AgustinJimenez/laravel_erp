<?php

namespace Modules\Productos\Http\Requests;

use App\Http\Requests\Request;

class MarcaRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if( $this->method()=='PUT' )//update
        {
            $uniquesRules= 
            [
                'nombre' => 'required|unique:productos__marcas,nombre,'.$this->marca->id,
                'codigo' => 'unique:productos__marcas,codigo,'.$this->marca->id
            ];
        }
        else
        {
            $uniquesRules= 
            [
                'nombre' => 'required|unique:productos__marcas',
                'codigo' => 'unique:productos__marcas'
            ];
        }

        $normalRules = [];

        $rules = array_merge( $normalRules, $uniquesRules );

        return $rules;





    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre es requerido',
            'nombre.unique' => 'El nombre ya existe en el sistema',
            'codigo.unique' => 'El codigo ya existe en el sistema'
        ];
    }
}