<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App;
class CategoryRequest extends FormRequest
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
        $locals =array_keys(App::make('languages')->toarray());
        $rules = [];
        foreach ($locals as $key ) {
            $rules["category_name.{$key}"] = "required|unique:tenant.categories,category_name->{$key},".$this->id;
        }
       $rules['categoryimg'] = 'mimes:jpeg,jpg,png,gif|max:10000';
       return $rules;
    }
}
