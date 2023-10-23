<?php

namespace App\Proadmin\Requests\Api;

use App\Proadmin\Rules\AllOrArrayRule;
use App\Proadmin\Rules\FieldsRule;
use App\Proadmin\Rules\RelationsRule;

class ShowRequest extends ApiRequest
{
    /**
	 * Set default values
     * 
	 * @return array
	 */
	public function validationData()
	{
		$data = $this->all();

		$data['fields']	= $data['fields'] ?? $this->route()->parameters()['menu_item']->getFields();
        $data['relations'] = $data['relations'] ?? [];

		return $data;
	}

    public function rules() : array
	{
        $rules = [
			'fields'	    => ['array'],
			'fields.*'	    => [new FieldsRule()],
			'relations'	    => [new AllOrArrayRule()],
			'relations.*'	=> [new RelationsRule()],
        ];

        return $rules;
    }
}
