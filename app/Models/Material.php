<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\MaterialUnit;
use App\Models\ModifierTemplate;

use Spatie\Translatable\HasTranslations;

class Material extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $connection ='tenant'; 

    public $translatable = ['material_name','material_description'];

    protected $fillable =['id',	'material_name','material_description','category_id','modifiertemplate_id','referance_id','materialimg','created_at','updated_at'];

        public function category()
        {
            return $this->belongsTo(Category::class, 'category_id');
        }

        public function units() {

            return $this->hasMany(MaterialUnit::class, 'material_id', 'id');
        }

        public function modifierTemplate(){
            return $this->belongsTo(Modifiertemplate::class,'modifiertemplate_id', 'id')->withDefault();
        }
        public function first_unit() {
            return $this->hasOne(MaterialUnit::class)->oldestOfMany()->withDefault();

         }
}
