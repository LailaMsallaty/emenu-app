<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App;
class StoreMaterialUnitRequest extends FormRequest
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
            $rules["List_units.*.{$key}"]="required|unique:tenant.material_units,material_unit_name->{$key}," . $this->id . ",id,material_id," . $this->material_id;
        }
        $rules["List_units.*.price"]="required";
        return $rules;
    }
}
