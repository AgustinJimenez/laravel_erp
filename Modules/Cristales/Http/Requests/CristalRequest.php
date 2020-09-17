<?php

namespace Modules\Cristales\Http\Requests;

use App\Http\Requests\Request;

class CristalRequest extends Request
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
        
        return ['nombre' => 'required','categoria_cristal_id' => 'required'];
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre del cristal es requerido',
            'categoria_cristal_id.required' => 'La categoria es requerida',

        ];
    }
}