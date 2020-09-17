<?php

namespace Modules\Proveedores\Http\Requests;

use App\Http\Requests\Request;

class ProveedoresRequest extends Request
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

        foreach ($this->all() as $key => $value)if($value == '')$this[$key] = null;

        if( $this->method()=='PUT' )//update
        {
            $uniquesRules= 
            [
                'email' => 'email|unique:proveedores__proveedors,email,'.$this->proveedor->id,
                'ruc' => 'unique:proveedores__proveedors,ruc,'.$this->proveedor->id
            ];
        }
        else
        {
            $uniquesRules= 
            [
                'email' => 'email|unique:proveedores__proveedors',
                'ruc' => 'unique:proveedores__proveedors'
            ];
        }

        $normalRules = 
        [
            'telefono' => 'numeric',
            'celular' => 'numeric',
            'fax' => 'numeric',
            'razon_social' => 'required'
        ];

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
            'razon_social.required' => 'Este campo es requerido',
            'email.email' => 'No es una direccion de email validad',
            'telefono.numeric' => 'El telefono debe ser numerico',
            'celular.numeric' => 'El celular debe ser numerico',
            'email.unique' => 'El email ya existe en el sistema',
            'ruc.unique' => 'El ruc ya existe en el sistema',
            'fax.numeric' => 'El fax debe ser numerico'
        ];
    }
}
