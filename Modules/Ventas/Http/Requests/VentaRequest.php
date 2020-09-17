<?php

namespace Modules\Ventas\Http\Requests;

use App\Http\Requests\Request;
use Illuminate\Support\Facades\Validator;
use Input;

class VentaRequest extends Request
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
            'cliente_id' => 'required',
            'nro_seguimiento'=> 'required',
            'fecha_venta' => 'required',
            'ojo_izq' => 'required',
            'ojo_der' => 'required',
            'distancia_interpupilar' => 'required'
        ];

        if($this['cantidad'])
        {
            foreach ($this['cantidad'] as $key => $value)
            {

                $rules['cantidad.'.$key] = 'required';
                $rules['precio_unitario.'.$key] = 'required';
                $rules['precio_total.'.$key] = 'required';

                if(!$this->producto_id[$key])
                {
                    if(!$this->servicio_id[$key])
                    {
                        if(!$this->cristal_id[$key])
                        {
                            if($this->tipo[$key]=='producto')
                            {
                                $rules['producto_id.'.$key] = 'required';
                            }
                            else if($this->tipo[$key]=='servicio')
                            {
                                $rules['servicio_id.'.$key] = 'required';
                            }  
                            else if($this->tipo[$key]=='cristal')
                            {
                                $rules['cristal_id.'.$key] = 'required';
                            } 
                        }
                    }
                }


            };
        }

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
            'cliente_id.required' => 'Hubo un error con el cliente, asegurese de seleccionarlo correctamente de la lista desplegable',
            'nro_seguimiento.required' => 'El nro de seguimiento es requerido',
            'fecha_venta.required' => 'La fecha es requerida',
            'ojo_izq.required' => 'Este campo es requerido',
            'ojo_der.required' => 'Este campo es requerido',
            'distancia_interpupilar.required' => 'Este campo es requerido',
        ];

        if($this['cantidad'])
        {
            foreach ($this['cantidad'] as $key => $value)
            {
                $messages['producto_id.'.$key.'.required'] = 'No se selecciono ningun producto de la fila '.($key+1);
                $messages['servicio_id.'.$key.'.required'] = 'No se selecciono ningun servicio  de la fila '.($key+1);
                $messages['cristal_id.'.$key.'.required'] = 'No se selecciono ningun cristal  de la fila '.($key+1);
                $messages['cantidad.'.$key.'.required'] = 'La cantidad es requerida';
                $messages['precio_unitario.'.$key.'.required'] = 'El precio unitario es requerido';
                $messages['precio_total.'.$key.'.required'] = 'El precio total es requerido';
            }
        }

        return $messages;

    }




}
