<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nimi', 'koko', 'valmistaja'
     ];

    /*
    *Tarvitaan pivot kyselyä varten
    *Yhdellä tuotteella voi olla monta listaa
    */

    public function lists(){
        return $this->belongsToMany('App\List', 'product_list');
    }
}
