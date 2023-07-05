<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;


class MaterialUnit extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $connection ='tenant'; 

    public $translatable = ['material_unit_name'];
    protected $fillable = ['id','material_unit_name','material_id','price','referance_id','created_at','updated_at'];

    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }
}
