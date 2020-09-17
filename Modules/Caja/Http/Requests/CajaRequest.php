<?php namespace Modules\Caja\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CajaRequest extends FormRequest {

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
		$this['monto_inicial'] = str_replace('.', '', $this['monto_inicial']);

		$rules =
        [
            'monto_inicial'=> 'required'
        ];

        return $rules;
	}

	public function messages()
    {
        $messages =
        [
            'monto_inicial.required' => 'El monto inicial es requerido',
        ];

        return $messages;

    }

}
