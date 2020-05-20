<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
  public function product(){
    return $this->belongsTo('App\Product');
  }
  public function seller(){
    return $this->belongsTo('App\User');
  }
  public function buyer(){
    return $this->belongsTo('App\User');
  }
  public function feedback(){
    return $this->hasOne('App\Feedback');
  }
  public function dispute(){
    return $this->hasOne('App\Dispute');
  }
}
