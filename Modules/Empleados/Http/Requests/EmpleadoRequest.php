<?php

namespace Modules\Empleados\Http\Requests;

use App\Http\Requests\Request;

class EmpleadoRequest extends Request
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
                'cedula' => 'numeric|required|unique:empleados__empleados,cedula,'.$this->empleado->id,
                'ruc' => 'unique:empleados__empleados,ruc,'.$this->empleado->id,
                'email' => 'unique:empleados__empleados,email,'.$this->empleado->id
            ];
        }
        else
        {
            $uniquesRules= 
            [
                'cedula' => 'numeric|required|unique:empleados__empleados',
                'ruc' => 'unique:empleados__empleados',
                'email' => 'unique:empleados__empleados'
            ];
        }

        $normalRules = 
        [
            'nombre' => 'required',
            'apellido' => 'required',
            'salario' => 'required'
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
            'nombre.required' => 'El nombre es requerido',
            'ruc.unique' => 'El ruc ya existe en el sistema',
            'email.unique' => 'El email ya existe en el sistema',
            'apellido.required' => 'El apellido es requerido',
            'cedula.required' => 'La cedula es requerida',
            'cedula.numeric' => 'La cedula debe ser numerica',
            'cedula.unique' => 'La cedula ya existe en el sistema',
            'salario.required' => 'El salario es requerido'
        ];
    }
}