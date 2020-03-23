<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UrlRequest extends FormRequest
{
    protected static $rules_array = [
        'url' => [ 'required' , 'regex:/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/isu']
    ];

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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return self::$rules_array;
    }

    public function validationData()
    {
        if( !$this->has("url")){
            return $this->all();
        }

       return $this->merge([
            "url" => trim(strip_tags($this->get("url")))
       ])->all();
    }
}
