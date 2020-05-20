<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Product extends Model
{
    public function category(){
      return $this->belongsTo('App\Category');
    }
    public function seller(){
      return $this->belongsTo('App\User');
    }
    public function buyer(){
      return $this->belongsTo('App\User');
    }

    public function bids(){
      return $this->hasMany('App\Bid');
    }
    public function purchases(){
      return $this->hasMany('App\Purchase');
    }



}
