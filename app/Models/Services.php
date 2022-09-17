<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Services extends Model
{
    use HasFactory;

    protected $table='services';
    protected $guarded=[];

    public function patient(){
        return $this->hasOne('App\Models\Patients','id','patient_id');
    }

    public function serviceStatus(){
        return $this->hasOne('App\Models\ServiceStatus','id','status_id');
    }

    public function prescriptions(){
        return $this->hasMany('App\Models\Prescriptions','service_id','id');
    }

    public function analysis(){
        return $this->hasMany('App\Models\Analysis','service_id','id');
    }
}
