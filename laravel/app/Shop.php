<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $fillable = ['shop'];

    public function user(){
    	/*pivot table*/
        return $this->belongsToMany('App\User', 'user_shops', 'user_id', 'shop_id');
    }
}
