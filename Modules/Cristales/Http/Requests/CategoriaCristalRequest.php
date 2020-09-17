<?php

namespace Modules\Cristales\Http\Requests;

use App\Http\Requests\Request;

class CategoriaCristalRequest extends Request
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
        

        if( $this->method()=='POST' )//store
        {
            return ['nombre' => 'required|unique:cristales__categoriacristales'];
        }
        else if( $this->method()=='PUT' )//update
        {    
            return ['nombre' => 'required|unique:cristales__categoriacristales,nombre,'.$this->categoriacristales->id];
            
        }
    
    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        return [
            'nombre.required' => 'El nombre de la categoria es requerido',
            'nombre.unique' => 'Ya existe otra categoria con ese nombre en el sistema'
        ];
    }
}