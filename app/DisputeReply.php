<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DisputeReply extends Model
{
    public function dispute(){
      return $this->belongsTo('App\Dispute');
    }
    public function user(){
        return $this->belongsTo('App\User');
    }
}
