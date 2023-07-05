<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ModifierTemplate;

use Spatie\Translatable\HasTranslations;

class Modifier extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $connection ='tenant'; 

    public $translatable = ['modifier_name'];

    protected $fillable = ['id','modifier_name','modifier_price','modifier_index','modifiertemplate_id','referance_id','created_at','updated_at'];

    public function modifierTemplate(){
        return $this->belongsTo(Modifiertemplate::class,'modifiertemplate_id', 'id');
    }
}
