<?php

namespace Modules\Contabilidad\Http\Requests;

use App\Http\Requests\Request;

class TipoCuentaRequest extends Request
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
                'codigo' => 'required|numeric|unique:contabilidad__tipocuentas,codigo,'.$this->tipocuenta->id,
                'nombre' => 'required|unique:contabilidad__tipocuentas,nombre,'.$this->tipocuenta->id
            ];
        }
        else
        {
            $uniquesRules= 
            [
                'codigo' => 'required|numeric|unique:contabilidad__tipocuentas',
                'nombre' => 'required|unique:contabilidad__tipocuentas'
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
        $required ='Este campo es requerido.';
        $numeric ='Este campo debe ser numerico.';
        $unique ='Este campo ya existe en el sistema.';

        return [
            'nombre.required' => $required,
            'nombre.unique' => $unique,
            'codigo.required' => $required,
            'codigo.unique' => $unique,
            'codigo.numeric' => $numeric,
        ];
    }
}