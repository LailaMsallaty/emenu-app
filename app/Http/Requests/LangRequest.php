<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LangRequest extends FormRequest
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
        if(isset($this->List_langs)){
            return [
                'List_langs.*.lang_code'=>'required|unique:tenant.langs,lang_code,'.$this->lang_id,
                'List_langs.*.lang_name'=>'required|unique:tenant.langs,lang_name,'.$this->lang_id,
            ];
        }
        else{
            return [
                'lang_code'=>'required|unique:tenant.langs,lang_code,'.$this->lang_id,
                'lang_name'=>'required|unique:tenant.langs,lang_name,'.$this->lang_id,
            ];
        }

    }
}
