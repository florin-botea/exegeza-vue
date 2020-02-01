<?php

namespace App\Http\Validations;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ValidBook extends FormRequest
{
    public function authorize()
    {
        return true;
    }

		// protected function getValidatorInstance() {
			// $this->setIndex();
			// return parent::getValidatorInstance();
		// }
		
    public function rules()
    {
		$form_field = request('book', 'store_form');
		\Session::flash('validating_form', $form_field);
		$bible = \App\Bible::where('slug', request('version'))->firstOrFail();
		$book = \App\Book::where(['bible_id' => $bible->id, 'slug' => request('book')])->first() ?? ['id' => 0];
		
		$rules = [
			'index' => 'required|Integer|unique:books,index,'.$book['id'].',id,bible_id,'.$bible->id,
			'name' => 'required|max:60|regex:/^[a-zA-Z]+[-a-zA-Z\d ]*[a-zA-Z\d]+$/',
			'slug' => 'required|max:30|regex:/^[a-zA-Z]+[-a-zA-Z\d]*[a-zA-Z\d]+$/|unique:books,slug,'.$book['id'].',id,bible_id,'.$bible->id
		];
		is_numeric($this->index) ? $rules['index'] .= '|gt:0|max:200' : '';

		return $rules;
    }
	
	public function messages(){
		return [
			'name.regex' => 'Bible name must start with letters, contain only letters|spaces|numbers|dashes(-) and end with letters|numbers',
			'slug.regex' => 'Bible alias must start with letters, contain only letters|numbers|dashes(-) and end with letters|numbers',
		];
	}
}
