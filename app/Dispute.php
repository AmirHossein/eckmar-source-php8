<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dispute extends Model
{
  public function purchase(){
    return $this->belongsTo('App\Purchase');
  }
  public function seller(){
    return $this->belongsTo('App\User','seller_id');
  }
  public function buyer(){
    return $this->belongsTo('App\User','buyer_id');
  }
  public function replies(){
    return $this->hasMany('App\DisputeReply');
  }
}
