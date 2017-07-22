<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /*
    *Tarvitaan pivot kyselyä varten
    *Yhdellä userilla voi olla monta kauppaa
    */

    public function shops(){
        return $this->belongsToMany('App\Shop', 'user_shops');
    }
}
