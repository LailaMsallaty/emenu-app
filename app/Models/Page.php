<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class Page extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $connection ='tenant'; 

    public $translatable = ['page_title','page_content'];
    protected $fillable = ['id','page_title','page_content','created_at','updated_at'];

}
