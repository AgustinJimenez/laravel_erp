<?php

namespace Modules\Compras\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Validator;
use Input;

class CompraRequest extends Request
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
        //dd($this->all());

        $rules =
        [
            'proveedor_id' => 'required',
            'fecha'=> 'required',
            'razon_social' => 'required',
            'ruc_proveedor' => 'required'
        ];

        foreach ($this->get('cantidad') as $key => $value)
        {

            $rules['cantidad.'.$key] = 'required';
            $rules['precio_unitario.'.$key] = 'required';

            if( $this->get('isProducto') == '1' )
            {
                //dd('es producto');

                $rules['producto_id.'.$key] = 'required';      
            }


        };

        //dd( $rules );

        return $rules;


    }

    /**
    * Get the error messages for the defined validation rules.
    *
    * @return array
    */
    public function messages()
    {
        //dd('messages');
        $messages=
        [
            'proveedor_id.required' => 'Hubo un error con el proveedor, asegurese de seleccionarlo correctamente de la lista desplegable',
            'razon_social.required' => 'La razon social es requerida',
            'fecha.required' => 'La fecha es requerida',
            'ruc_proveedor.required' => 'El ruc es requerido'
        ];

        foreach ($this->get('cantidad') as $key => $value)
        {
            $messages['producto_id.'.$key.'.required'] = 'No se selecciono ningun producto de la fila '.($key+1);
            $messages['cantidad.'.$key.'.required'] = 'La cantidad es requerida';
            $messages['precio_unitario.'.$key.'.required'] = 'El precio unitario es requerido';
        }

        return $messages;

    }




}
