<?php

namespace App\Http\Validations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ValidReply extends FormRequest
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
            'comment_id' => 'Integer|exists:comments,id',
            'author' => 'Integer|exists:users,id',
            'text' => 'String|between:20,2000',
        ];
    }
		
		public function setAuthor(){
				$post = $this->all();
				$post['author'] = isset($post['author']) ? $post['author']['id'] : Auth::id();
				$this->replace($post);
		}
}
