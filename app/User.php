<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     *
     *
     */

    protected $table ='users';

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

    // ONE TO ONE relacija
    public function post() {

        return $this->hasOne('App\Post');

    }


    // ONE TO MENY relacija

    public function posts(){

        return $this->hasMany('App\Post');
    }




/*    public function roles(){
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');

    }*/

//    public function roles(){
//        return $this->belongsToMany('App\Role');
//
//    }

    public function roles(){
        return $this->belongsToMany('App\Role')->withPivot('created_at');

    }

    public function photos(){

        return $this->morphMany('App\Photo', 'imageable');
    }


}
