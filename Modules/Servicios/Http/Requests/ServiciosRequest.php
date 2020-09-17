<?php

namespace Modules\Servicios\Http\Requests;

use App\Http\Requests\Request;

class ServiciosRequest extends Request
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
                'nombre' => 'required|unique:servicios__servicios,nombre,'.$this->servicio->id,
                'codigo' => 'unique:servicios__servicios,codigo,'.$this->servicio->id,
            ];
        }
        else
        {
            $uniquesRules= 
            [
                'nombre' => 'required|unique:servicios__servicios',
                'codigo' => 'unique:servicios__servicios',
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
            'nombre.unique'  => 'El nombre ya existe el la base de datos',
            'codigo.unique' => 'El codigo ya existe en el sistema'
        ];
    }
}
