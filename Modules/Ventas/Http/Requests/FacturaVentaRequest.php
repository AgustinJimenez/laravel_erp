<?php namespace Modules\Ventas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FacturaVentaRequest extends FormRequest {

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
		 $rules =
        [
            'razon_social' => 'required',
            'ruc'=> 'required',
            'fecha' => 'required',
            'direccion' => 'required',
            'forma_pago' => 'required',
            'monto_total' => 'required',
            'monto_total_letras' => 'required',
            'total_iva_5' => 'required',
            'total_iva_10' => 'required',
            'total_iva' => 'required'
        ];

        foreach ($this['cantidad'] as $key => $value)
        {

            //$rules['cantidad.'.$key] = 'required';
            //$rules['precio_unitario.'.$key] = 'required';

        };


		return $rules;
	}

	public function messages()
    {
        $required_message = 'este campo es requerido';

        $messages=
        [
            'razon_social.required' => $required_message,
            'ruc.required' => $required_message,
            'fecha.required' => $required_message,
            'direccion.required' => $required_message,
            'forma_pago.required' => $required_message,
            'monto_total.required' => $required_message,
            'monto_total_letras.required' => $required_message,
            'total_iva_5.required' => $required_message,
            'total_iva_10.required' => $required_message,
            'total_iva.required' => $required_message
        ];

        foreach ($this['cantidad'] as $key => $value)
        {
            //$messages['cantidad.'.$key.'.required'] = 'La cantidad es requerida';
            //$messages['precio_unitario.'.$key.'.required'] = 'El precio unitario es requerido';
        }

        return $messages;

    }

}
