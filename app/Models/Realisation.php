<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Realisation extends Model
{
	protected $table="item_user";


	public function item(){
		return $this->belongsTo('\App\Models\Item');
	}

	public function user(){
		return $this->belongsTo('\App\Models\User');
	}

}
