<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patients extends Model
{
    use HasFactory;

    protected $table='patients';
    protected $guarded=[];

    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
