<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Partner extends Model
{

    public $timestamps = false;
 	//protected $appends = ['weektopscores'];


    public function poses()
    {
        return $this->hasMany('\App\Models\Pos');
    }


    public function users()
    {	
    	//https://laravel.com/docs/5.1/eloquent-relationships
    	return $this->hasManyThrough('\App\Models\User', '\App\Models\Pos', 'partner_id', 'pos_id');
    }





    public function realisations(){
        $userIds=$this->users()->lists('users.id');
        return
            \App\Models\Realisation::whereIn('user_id',$userIds)
            ->with('user','item')
            ;
    }


    public function weeksales(){
        $userIds=$this->users()->lists('users.id');
        return
            \App\Models\Realisation::whereIn('user_id',$userIds)
            ->addSelect(\DB::raw('sum(item_user.points) as total'))
            ->addSelect(\DB::raw('count(*) as qty'))
            ->addSelect(\DB::raw('WEEK(date,5) as week'))
            ->groupBy('week');
    }

/*

    public function topitems()
    {
        return  $this->items()
            ->addSelect(\DB::raw('sum(item_user.points) as total'))
            ->addSelect(\DB::raw('count(*) as qty'))
            ->addSelect('items.name')
            ->groupBy('item_user.item_id');
    }

    public function weeksales()
    {
        return  $this->items()
            ->addSelect(\DB::raw('sum(item_user.points) as total'))
            ->addSelect(\DB::raw('count(*) as qty'))
            //->addSelect(\DB::raw('WEEKOFYEAR(date) as week'))
            ->addSelect(\DB::raw('WEEK(date,5) as week'))
            ->groupBy('week');
    }

 */

}
