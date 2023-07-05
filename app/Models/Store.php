<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [	'id',	'name'	,'domain'	,'database_options'	,'db_username','db_password','created_at'	,'updated_at'];

    protected $casts =
    [
        'database_options'=>'array'
    ];

    public function users(){
        return $this->hasMany(User::class,'store_id', 'id');
    }
}
