<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserShop extends Model
{
    protected $fillable = ['shop_id', 'user_id', 'lista_id'];

    public function user(){
        return $this->belongsTo('App\Shop');
        //return $this->belongsTo('App\User');
    }
    /*public function lista(){
         return $this->belongsToMany('App\User');
        //return $this->belongsTo('App\User');
    }*/
}
