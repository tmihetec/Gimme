<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Silber\Bouncer\Database\HasRolesAndAbilities;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{

    use SoftDeletes;
    use HasRolesAndAbilities;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


     /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['display_name','formatedresultw', 'affiliate', 'formatedresultm','formatedresultq','formatedresultc','pos_display_name'];



    //---------------------------------------------------------------------------- 

    /**
     * Get the user's display name.
     *
     * @param  string  $value
     * @return string
     */
    public function getDisplayNameAttribute($value)
    {        
        $display_name=$this->firstname." ".$this->lastname;
        if (trim($display_name)=="") 
        {
            $display_name=$this->name;
        }
        return ucfirst($display_name);
    }



    public function getAffiliateAttribute($value)
    {        
        return $this->is('affiliate');
    }


/*
    // tjedni rezultat 
    // 1) u tablici resultw
    // 2) getThisweekscoreAttribute
    // 3) relacija

   public function getThisweekscoreAttribute()
    {
        $q= $this->items()->where('date','>=',\Carbon\Carbon::now()->startOfWeek()->format("Y-m-d"))
            ->addSelect(\DB::raw('sum(item_user.points) as total'))
            ->addSelect(\DB::raw('count(*) as qty'))
            ->first();

        return [
                'total'=>$q['total'], 
                'qty'=>$q['qty']
            ];
    }

    public function thisweeksales()
    {
        return $this->belongsToMany('\App\Models\Item')->withPivot('points','date')
            ->where('date','>=',\Carbon\Carbon::now()->startOfWeek()->format("Y-m-d"))            
            ;
    }

*/


    public function thisweeksales()
    {
        return $this->belongsToMany('\App\Models\Item')->withPivot('points','date')
            ->where('date','>=',\Carbon\Carbon::now()->startOfWeek()->format("Y-m-d"))            
            ;
    }



    public function pos(){
        return $this->belongsTo('\App\Models\Pos')->with('partner');
    }

    public function getPosDisplayNameAttribute(){
        if($this->pos && $this->pos->partner()->first())
        {
            return $this->pos->partner()->first()->name.": ".$this->pos->name;
        } else if ($this->pos) {
            return $this->pos->name;
        } else return "None assigned";
    }

    public function getFormatedresultmAttribute()
    {
        return number_format($this->attributes['resultm'],0, ',', '.');
    }
    public function getFormatedresultwAttribute()
    {
        return number_format($this->attributes['resultw'],0, ',', '.');
    }
    public function getFormatedresultqAttribute($pts)
    {
        return number_format($this->attributes['resultq'],0, ',', '.');
    }
    public function getFormatedresultcAttribute($pts)
    {
        return number_format($this->attributes['resultc'],0, ',', '.');
    }



    public function items(){
            return $this->belongsToMany('\App\Models\Item')->withPivot('id','points','date','invoice')->withTimestamps();
    }


    public function topitems()
    {
        return  $this->items()
            ->addSelect(\DB::raw('sum(item_user.points) as total'))
            ->addSelect(\DB::raw('count(*) as qty'))
            ->addSelect('items.name')
            ->groupBy('item_user.item_id');
    }

    /** weeksales 
        po tjednima za tekuću godinu!
     */
    public function weeksales()
    {
        return  $this->items()
            ->addSelect(\DB::raw('sum(item_user.points) as total'))
            ->addSelect(\DB::raw('count(*) as qty'))
            //->addSelect(\DB::raw('WEEKOFYEAR(date) as week'))
            ->addSelect(\DB::raw('WEEK(date,5) as week'))
            ->groupBy('week');
    }




}
