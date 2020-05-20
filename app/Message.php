<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    public function To(){
      return $this->belongsTo('App\User','to');
    }
    public function From(){
      return $this->belongsTo('App\User','from');
    }
}
