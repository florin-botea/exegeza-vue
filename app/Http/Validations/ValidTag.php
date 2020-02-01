<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;

class ValidTag extends FormRequest
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
				$this->setUserIdAndTarget();
				return parent::getValidatorInstance();
		}
		
    public function rules()
    {
        return [
            'target' => 'Integer|min:999999',
            'author' => 'Integer|exists:users,id',
            'title' => 'String|between:10,120',
            'text' => 'String|between:50,64000',
			'tags' => 'Array'
        ];
    }
		
		public function setUserIdAndTarget(){
				$post = $this->all();
				$post['author'] = 1; //cel ce posteaza
				$post['target'] = \Request::route('text');
				$this->replace($post);
		}
}