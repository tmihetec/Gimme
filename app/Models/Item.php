<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;


class Item extends Model
{

//	use SoftDeletes;

	protected $append = ['text','aktivan','scores'];
    //


	//set mutators for all your foreign keys to use NULL if no value:
	public function setCategoryIdAttribute($value) {
	    $this->attributes['category_id'] = $value ?: null;
	}

	public function setBrandIdAttribute($value) {
	    $this->attributes['brand_id'] = $value ?: null;
	}



	public function points()
	{
		return $this->hasMany('App\Models\Itempoints')->orderBy('startdate','DESC')->orderBy('created_at','DESC');
	}

	public function latestpoints()
	{
		return $this->hasOne('App\Models\Itempoints')->orderBy('startdate','DESC')->orderBy('created_at','DESC');
	}


	public function getAktivanAttribute(){
		//return $this->trashed() ? 0 : 1;

		// tu se može provjeriti i da li je i kategorija i njegov brand active??
		return ($this->active ) ? 1 : 0; //&& !$this->trashed()
		
	}


	/**
	 * vraća custom naziv artikla u selectu za add2score
	 * @return [type] [description]
	 */
	public function getTextAttribute(){

		$open = false;

		$text=($this->brand) ? $this->brand->name : "";
		if (trim($text)!=="") $text.=" ";

		if ($this->category && trim($this->category->name)!=="") 
			{
				$text.=$this->category->name." ";
			}
	
		$text.=$this->name;
		if (trim($this->sku)!=="") {
			$open=true;
			$text.=" (sku: ".$this->sku;
		}
		if (trim($this->pn)!=="") {
			if ($open){
				$text.=" | pn: ".$this->pn;
			} else {
				$open=true;
				$text.=" (pn: ".$this->pn;
			}
		}
		if ($open) $text.=")";

		return $text;
	}

	public function brand(){
		return $this->belongsTo('App\Models\Brand','brand_id'); 
	}

	public function category(){
		return $this->belongsTo('App\Models\Category','category_id'); 
	}


	public function getScoresAttribute()
	{
		$q=	\DB::table('item_user')
			->select(\DB::raw(' count(*) as sc '))
			->where('item_id','=',$this->id)
			->first()
		;
		return $q->sc;
	}

	/*vraća sve prodaje (usere) (i više puta ak ima)*/
	public function realisations(){
		//return $this->hasMany('\App\Models\Realisation');
        return $this->belongsToMany('\App\Models\User')->withPivot('id','points','date','invoice')->withTimestamps();
	}


	public function realisationsdataw(){
		$weekStart=\Carbon\Carbon::now()->startOfWeek()->format("Y-m-d");
		$weekEnd=\Carbon\Carbon::now()->endOfWeek()->format("Y-m-d");
		return $this->hasMany('\App\Models\Realisation')->where('date','>=',$weekStart)->where('date','<=',$weekEnd);
	}

	public function realisationsdataM(){
		$monthStart=\Carbon\Carbon::now()->firstOfMonth()->format("Y-m-d");
		$monthEnd=\Carbon\Carbon::now()->lastOfMonth()->format("Y-m-d");
		return $this->hasMany('\App\Models\Realisation')->whereBetween('date', [$monthStart, $monthEnd]);
	}
	public function realisationsdataQ(){
		$quarterStart=\Carbon\Carbon::now()->firstOfQuarter()->format("Y-m-d");
		$quarterEnd=\Carbon\Carbon::now()->lastOfQuarter()->format("Y-m-d");
		return $this->hasMany('\App\Models\Realisation')->whereBetween('date', [$quarterStart, $quarterEnd]);
	}



}
