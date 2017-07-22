<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lista extends Model
{
    protected $fillable = ['nimi', 'usershops_id'];

    public function product(){
    	/*pivot table*/
        return $this->belongsToMany('App\Product', 'product_lists', 'list_id', 'product_id');
    }
}
