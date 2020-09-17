<?php

namespace Modules\Productos\Http\Requests;

use App\Http\Requests\Request;

class ProductoRequest extends Request
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
        if( !$this->nombre )
            $this['nombre'] = null;
        
        if( $this->method()=='PUT' )//update
        {
            $uniquesRules= 
            [
                'codigo' => 'required|unique:productos__productos,codigo,'.$this->producto->id
            ];
        }
        else
        {
            $uniquesRules= 
            [
                'codigo' => 'required|unique:productos__productos'
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
            //'nombre.required' => 'El nombre es requerido',
            //'nombre.unique' => 'El nombre ya existe en el sistema',
            'codigo.unique' => 'El codigo ya existe en el sistema',
            'codigo.required' => 'El codigo es requerido'
        ];
    }
}