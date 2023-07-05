<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App;

class ModifierTemplateRequest extends FormRequest
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
        if(isset($this->List_modifiers)){
            foreach ($locals as $key ) {
                $rules["List_modifiers.*.{$key}"]="required";
            }
            $rules["List_modifiers.*.price"]="required";
        }
        $rules["templateName"] ="required|unique:tenant.modifier_templates,modifiertemplate_name,".$this->id;
        return $rules;
    }
}
