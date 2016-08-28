<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pos extends Model
{
    

    protected $append=['full_name'];
    protected $table='poses';
    public $timestamps = false;


    public function partner(){
    	return  $this->belongsTo('\App\Models\Partner','partner_id');
    }
    
    public function getFullNameAttribute(){
    	return ($this->partner()->exists()) ?  $this->partner()->first()->name.": ".$this->attributes['name'] : $this->attributes['name'];
    }

    public function users(){
            return $this->hasMany('\App\Models\User');
    }


}
