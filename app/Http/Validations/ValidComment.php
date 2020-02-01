<?php

namespace App\Http\Validations;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;

class ValidComment extends FormRequest
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
		$this->setAuthor();
		return parent::getValidatorInstance();
	}
		
    public function rules()
    {
        return [
            'target' => 'Integer|min:999999',
            'author' => 'Integer|exists:users,id',
            'title' => 'String|between:10,120',
            'text' => 'String|between:50,5000',
			'tags' => 'Array'
        ];
    }
		
	public function setAuthor(){
		$post = $this->all();
		$post['author'] = isset($post['author']) ? $post['author']['id'] : Auth::id();
		$this->replace($post);
	}
}