<?php namespace Modules\Clientes\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Media\Entities\File;

class ClienteExcelRequest extends FormRequest {

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
		$re = $this;

		$archivo = File::where('id', $re['medias_single']['archivo'])->first();

        $file_path = base_path().'/public/assets/media/'.$archivo->filename;

        $columns = Excel::load($file_path)->get();

        foreach ($columns as $key => $column) 
	        foreach ($column as $key2 => $row) 
	        {
	            $cliente = $row->all();

	            foreach ($cliente as $key3 => $campo) 
	                if( gettype($campo) == 'double' )
	                    $cliente[$key3] = (string)intval($campo);
	            if($cliente['activo'] )
	                $cliente['activo'] = '1';
	            else
	                $cliente['activo'] = '0';

	            $clientes[] = $cliente;

	        }
            
        foreach ($clientes as $key => $value) 
        {

            if($value == '')
                $this[$key] = null;
            
        }



		return [
			//
		];
	}

}
