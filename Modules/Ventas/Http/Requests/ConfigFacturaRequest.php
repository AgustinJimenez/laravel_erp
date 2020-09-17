<?php namespace Modules\Ventas\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Validator;
use Input;

class configFacturaRequest extends FormRequest {

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
		
		foreach($this->get('valor') as $key => $val)
        {
            $rules['valor.'.$key] = 'required|numeric';
        }

        return $rules;
	}

	public function messages()
    {
        foreach($this->get('valor') as $key => $val)
        {
            $messages['valor.'.$key.'.required'] = 'Este campo es requerido';

            $messages['valor.'.$key.'.numeric'] = 'Este campo debe ser numerico';
        }

        return $messages;

    }

}
