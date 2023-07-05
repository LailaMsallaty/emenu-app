<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App;

class MaterialRequest extends FormRequest
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
            $rules["material_name.{$key}"] = "required|unique:tenant.materials,material_name->{$key},".$this->id;
            $rules["List_units.*.{$key}"]="required";
        }

       $rules["List_units.*.price"]="required";
       $rules["materialimg"] = "mimes:jpeg,jpg,png,gif|max:10000";
       $rules["categoryparent"] ="required";
       return $rules;
    }
}
