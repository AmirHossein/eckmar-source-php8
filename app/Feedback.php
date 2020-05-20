<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
  public function seller(){
    return $this->belongsTo('App\User');
  }
  public function buyer(){
    return $this->belongsTo('App\User');
  }
  public function purchase(){
    return $this->belongsTo('App\Purchase');
  }
}
