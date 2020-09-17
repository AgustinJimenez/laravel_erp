<?php

namespace Modules\Contabilidad\Http\Requests;

use App\Http\Requests\Request;

class CuentaRequest extends Request
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
        //dd($this->all() );

        return [
                    'nombre' => 'required'
                ];
 
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        $requerido ='Este campo es requerido.';

        return [
            'nombre.required' => $requerido
        ];
    }
}