<?php

namespace App\Http\Validations;

use Illuminate\Foundation\Http\FormRequest;

class ValidUser extends FormRequest
{

    public function authorize()
    {
        return true;
    }

	protected function getValidatorInstance() {
		$post = $this->all();
		$post['description'] = $this->description ?? '';
		$this->replace($post);
		
		return parent::getValidatorInstance();
	}
		
    public function rules()
    {
        $rules = [
			'name' => 'required|String|between:4,30',
			'age' => 'Integer|nullable|gt:0|max:100',
			'email' => 'sometimes|required|email|unique:users,email,'.auth()->id(),
			'gender' => 'Integer|nullable|gt:-1|max:2',
			'description' => 'sometimes|String|between:0,1000',
			//'photo' => 'sometimes|mimes:jpeg,png,jpg|max:2048'
		];
		is_numeric($this->age) ? $rules['age'] = 'Integer|gt:0|max:100' : '';
		is_numeric($this->gender) ? $rules['gender'] .= '|gt:-1|max:2' : '';

		return $rules;
    }
}
