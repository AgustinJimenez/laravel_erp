<?php

namespace Modules\Cristales\Http\Requests;

use App\Http\Requests\Request;

class TipoCristalRequest extends Request
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
                'nombre' => 'required',
                'codigo' => 'unique:cristales__tipocristales,codigo,'.$this->tipocristales->id
            ];
        }
        else
        {
            $uniquesRules= 
            [
                'nombre' => 'required',
                'codigo' => 'unique:cristales__tipocristales'
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
            'nombre.required' => 'Este campo es requerido',
            'codigo.unique' => 'El codigo ya existe en el sistema'
        ];
    }
}
