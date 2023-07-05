<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App;
class PageRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $locals = array_keys(App::make('languages')->toarray());
        $rules = [];
        foreach ($locals as $key ) {
            $rules["page_title.{$key}"] = "required|unique:tenant.pages,page_title->{$key},".$this->id;
        }
        $rules["content.*"] = "required";

        return $rules;
    }
}
