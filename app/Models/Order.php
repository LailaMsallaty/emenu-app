<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $connection ='tenant'; 

    protected $fillable = ['id','order_date','client_name','client_email','tablecode','ordertotal','orderdetail','isposted','posteddate','created_at','updated_at'];

}
