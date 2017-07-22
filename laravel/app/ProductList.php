<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductList extends Model
{
    protected $fillable = ['product_id', 'list_id'];

    public function product(){
        return $this->belongsTo('App\Product');
        //return $this->belongsTo('App\User');
    }
}
