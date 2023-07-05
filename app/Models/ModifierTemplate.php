<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Material;
use App\Models\Modifier;

class ModifierTemplate extends Model
{
    use HasFactory;
    protected $connection ='tenant'; 

    protected $fillable = ['id','modifiertemplate_name','referance_id','created_at','updated_at'];

    public function categories()
    {
        return $this->hasMany(Category::class, 'modifiertemplate_id', 'id');
    }
    public function materials()
    {
        return $this->hasMany(Material::class, 'modifiertemplate_id', 'id');
    }
    public function modifiers()
    {
        return $this->hasMany(Modifier::class, 'modifiertemplate_id', 'id');
    }

}
