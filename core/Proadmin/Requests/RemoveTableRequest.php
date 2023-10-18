<?php

namespace App\Proadmin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RemoveTableRequest extends FormRequest
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
	 * Prepare the data for validation.
	 *
	 * @return void
	 */
	protected function prepareForValidation()
	{
		$this->merge([
            'id'            => intval($this->id),
        ]);
	}

    public function rules()
	{
		$rules = [
            'id'            => ['required', 'integer'],
        ];

        return $rules;
    }
}
