<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    //
    public $fillable = [
      'lat',
      'long'
    ];

    public function user(){
      return $this->belongsTo('App\User');
    }
}
