<?php

namespace App\Http\Validations;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\Request;

class ValidSuggestion extends FormRequest
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
		
    public function rules()
    {
        return [
            'author' => 'required|String|between:10,120',
            'text' => 'required|String|between:50,2000'
        ];
    }
}