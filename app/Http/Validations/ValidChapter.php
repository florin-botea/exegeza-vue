<?php

namespace App\Http\Validations;

use Illuminate\Foundation\Http\FormRequest;

class ValidChapter extends FormRequest
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
		$form_field = request('chapter', 'store_form');
		\Session::flash('validating_form', $form_field); 
		$book = \App\Book::where('slug', request('book'))->first();
		$chapter = \App\Chapter::where(['book_id' => $book->id, 'index' => request('chapter')])->first() ?? ['id'=>0];
		
		$rules = [
			'text' => 'required|String|max:60',
			'index' => 'required|Integer|unique:chapters,index,'.$chapter['id'].',id,book_id,'.$book->id,
		];
		is_numeric($this->index) ? $rules['index'] .= '|gt:0|max:200' : '';
		$this->add_verses ? $rules['regexp'] = 'regex:/^\/.+\/$/' : '';

		return $rules;
    }
}
