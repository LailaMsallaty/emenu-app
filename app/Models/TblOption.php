<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TblOption extends Model
{
    use HasFactory;
    protected $connection ='tenant'; 

    /**
     * Class constructor.
     */

    public function __construct()
    {

    }
    protected $fillable=['id','opvar','opval','created_at','updated_at'];

    function getOPtionVal($opvar) {
        $obj = TblOption::where('opvar',$opvar)->get()->first();
        return ($obj) ? $obj->opval:"";
    }
}
