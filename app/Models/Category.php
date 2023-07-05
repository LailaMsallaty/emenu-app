<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use App\Models\ModifierTemplate;

class Category extends Model
{
    use HasFactory;
    use HasTranslations;

    protected $connection ='tenant';

    public $translatable = ['category_name','category_description'];
    protected $fillable  = ['id','category_name','category_father_id','category_description','categoryimg','category_index','modifiertemplate_id', 'created_at', 'updated_at'];

    public function subcategories()
    {
        return $this->hasMany(Category::class, 'category_father_id', 'id');
    }
    public function parent()
    {
        return $this->belongsTo(Category::class,'category_father_id', 'id')->withDefault();
    }
    public function modifierTemplate(){
        return $this->belongsTo(Modifiertemplate::class,'modifiertemplate_id', 'id')->withDefault();
    }

    public function materials()
    {
        return $this->hasMany(Material::class, 'category_id', 'id');
    }
}
