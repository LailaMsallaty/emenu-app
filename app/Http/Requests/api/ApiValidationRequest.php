<?php

namespace App\Http\Requests\api;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Category;
use App\Models\Material;
use App\Models\MaterialUnit;
use App;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Validation\ValidationException;
class ApiValidationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(app()->bound('store.active'))
        {
        $active_store = app()->make('store.active');
        $authorized=true;
        if(isset($active_store->domain))
        {
        $user =Auth::user();
         if($user){
            if(($user->store_id) !== ($active_store->id)){
                $authorized =false;
                throw ValidationException::withMessages([
                    'email' => __('This user has no permission to access this site.'),
                ]);
            }
         }
        } 
       }  
        return $authorized;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];
        $locals =array_keys(App::make("languages")->toarray());
        if ($this->request_type =='addCategory') {
            $rules['category'] ="required";
            $rules['category.*.category_lang']="required";
            $rules['category.*.reference_id']="required";
            foreach ($locals as $key ) {
                $rules['category.*.category_lang.*.category_lang_name']="required|unique:tenant.categories,category_name->{$key}";
            }
            $rules['category.*.category_lang.*.lang_id']="required";

        }
        if ($this->request_type =='updateCategory') {
            $rules['category'] ="required";
            $rules['category.category_id']="required|exists:tenant.categories,reference_id";
            $rules['category.reference_id']="required|exists:tenant.categories,reference_id";
            $rules['category.category_lang']="required";
            $rules['category.category_lang.*.lang_id']="required";
            foreach ($locals as $key ) {
                $rules['category.category_lang.*.category_lang_name']="required|unique:tenant.categories,category_name->{$key},".((isset($this->category))?Category::where('reference_id',$this->category['category_id'])->first()->id:'');
            }
        }
        if ($this->request_type =='deleteCategory') {
               $rules['reference_id']="required|exists:tenant.categories,reference_id";
        }
        if ($this->request_type =='addMaterial') {
            $rules['material'] ="required";
            $rules['material.*.category_id']="required|exists:tenant.categories,reference_id";
            $rules['material.*.reference_id']="required";
            $rules['material.*.material_lang']="required";
            $rules['material.*.material_lang.*.lang_id']="required";
            foreach ($locals as $key ) {
                $rules['material.*.material_lang.*.material_lang_name']="required|unique:tenant.materials,material_name->{$key}";
            }
            $rules['material.*.material_unit']="required";
            $rules['material.*.material_unit.*.price']="required";
            $rules['material.*.material_unit.*.material_unit_lang']="required";
            $rules['material.*.material_unit.*.material_unit_lang.*.material_unit_lang_name']="required";
            $rules['material.*.material_unit.*.material_unit_lang.*.lang_id']="required";
        }
        if ($this->request_type =='updateMaterial') {
            $rules['material'] ="required";
            $rules['material.category_id']="required|exists:tenant.categories,reference_id";
            $rules['material.reference_id']="required";
            $rules['material.material_id']="required|exists:tenant.materials,reference_id";
            $rules['material.material_lang']="required";
            foreach ($locals as $key ) {
                $rules['material.material_lang.*.material_lang_name']="required|unique:tenant.materials,material_name->{$key},".((isset($this->material))?Material::where('reference_id',$this->material['material_id'])->first()->id:'');
            }
        }
        if ($this->request_type =='deleteMaterial') {
            $rules['reference_id']="required|exists:tenant.materials,reference_id";
        }
        if ($this->request_type =='updateUnit') {
            $rules['unit'] ="required";
            $rules['unit.material_unit_id']="required|exists:tenant.material_units,reference_id";
            $rules['unit.material_id']="required|exists:tenant.materials,reference_id";
            $rules['unit.reference_id']="required";
            $rules['unit.price']="required";
            $rules['unit.unit_lang']="required";
            foreach ($locals as $key ) {
                $rules['unit.unit_lang.*.material_unit_lang_name']="required|unique:tenant.material_units,material_unit_name->{$key}," .  ((isset($this->Unit))?MaterialUnit::where('reference_id',$this->Unit['material_unit_id'])->first()->id:'') . ",id,material_id," . ((isset($this->Unit))?Material::where('reference_id',$this->Unit['material_id'])->first()->id:'');
            }
        }
        if ($this->request_type =='addModifierTemplate') {
            $rules['ModifierTemplate'] ="required";
            foreach ($locals as $key ) {
            $rules['ModifierTemplate.*.modifiertemplate_name']="required|unique:tenant.modifier_templates,modifiertemplate_name->{$key}";
            }
            $rules['ModifierTemplate.*.reference_id']="required";
            $rules['ModifierTemplate.*.modifier']="required";
            $rules['ModifierTemplate.*.modifier.*.modifier_price']="required";
            $rules['ModifierTemplate.*.modifier.*.reference_id']="required";
            $rules['ModifierTemplate.*.modifier.*.modifier_lang']="required";
            $rules['ModifierTemplate.*.modifier.*.modifier_lang.*.modifier_lang_name']="required";
            $rules['ModifierTemplate.*.modifier.*.modifier_lang.*.lang_id']="required";

        }

        return $rules;
    }
}
