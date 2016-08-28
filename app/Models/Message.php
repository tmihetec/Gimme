<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    // 1) admin kreira poruku
    // 2) odredi klasu
    // 3) odredi kome (forma) - svi partneri, svi pos, svi useri
    // 4) izvadi se lista korisnika prema selectu iz 3
    // 5) u pivot se utrpaju veze (msg-user), seen je na false
    // 
    // a) revokaj poruku korisniku = izbriši iz pivota
    // b) nema izmjene/brisanja ak je neko već pogledao, samo revoke (od svih ili od nekog usera - bulk action)
    // c) resend onima koji su pogledali
    // d) send još onima kojima nije namjenjen (nema u pivotu)?
    // 
    // a) kad user dismisa, upiše se pod seendatetime
    // b) u tablicu se može upisati na koliko je sve usera poslano, i koliko ih je od njih vidlo


	public function author()
    {
        return $this->belongsTo('\App\Models\User','user_id');
    }


    public function recipients()
    {
        return $this->belongsToMany('\App\Models\User','message_user', 'message_id', 'user_id');
    }    
}

