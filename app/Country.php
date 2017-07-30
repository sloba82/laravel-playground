<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    //


    // user pripada drzavi, hocemo kroz post da saznamo odakle je user
    public function posts(){

        return $this->hasManyThrough('App\Post', 'App\User' /*. 'country_id'*/ ); // 'country_id' je parametar koji se definise ako je naziv kolone u tabeli drugaciji od konvencije
    }




}
