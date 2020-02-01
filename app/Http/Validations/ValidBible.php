<?php

namespace App\Http\Validations;

use Illuminate\Foundation\Http\FormRequest;

class ValidBible extends FormRequest
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

	protected function getValidatorInstance() {
		$post = $this->all();
		$this->public ? '' : $post['public'] = 0;
		$this->replace($post);
		return parent::getValidatorInstance();
	}
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
		$unique = '|unique:bibles,slug';
		$version_slug = request('traducere');
		$form_field = $version_slug ?? 'store_form';
		
		$same_slug_and_update = strtolower($version_slug) == strtolower($this->slug);
		if ( $same_slug_and_update ){
			$unique = '';
		}
		\Session::flash('validating_form', $form_field); 
		
        return [
			'name' => 'required|max:60|regex:/^[a-zA-Z]+[-a-zA-Z\d ]*[a-zA-Z\d]+$/',
			'alias' => 'required|max:10|regex:/^[a-zA-Z]+[-a-zA-Z\d ]*[a-zA-Z\d]+$/',
			'slug' => 'required|max:30|regex:/^[a-zA-Z]+[-a-zA-Z\d]*[a-zA-Z\d]+$/'.$unique
        ];
    }
	
	public function messages(){
		return [
			'name.regex' => 'Bible name must start with letters, contain only letters|spaces|numbers|dashes(-) and end with letters|numbers',
			'alias.regex' => 'Bible alias must start with letters, contain only letters|spaces|numbers|dashes(-) and end with letters|numbers',
			'slug.regex' => 'Bible alias must start with letters, contain only letters|numbers|dashes(-) and end with letters|numbers',
		];
	}
}
