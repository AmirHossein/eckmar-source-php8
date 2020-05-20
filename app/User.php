<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function application(){
        return $this->hasMany('App\VendorApplication');
    }
    public function products(){
        return $this->hasMany('App\Product','seller_id');
    }
    public function purchases(){
      return $this->hasMany('App\Purchase','buyer_id');
    }
    public function sales(){
      return $this->hasMany('App\Purchase','seller_id');
    }
    public function feedback(){
      return $this->hasMany('App\Feedback','for');
    }
    public function receivedmessages(){
      return $this->hasMany('App\Message','to');
    }
    public function sentmessages(){
      return $this->hasMany('App\Message','from');
    }
    public function feedbackScore(){
      $positive = $this->feedback()->where('positive',true)->count();
      $negative = $this->feedback()->where('positive',false)->count();
      $total = $positive + $negative;
      if ($total !== 0) {
          $score = round((100*$positive)/$total);
      } else {
        $score = 0;
      }

      return $score;
    }
    public function trustRating(){
      $positive = $this->feedback()->where('positive',true)->count();
      $negative = $this->feedback()->where('positive',false)->count();
      $total = $positive + $negative;
      if ($total !== 0) {
          $score = round((100*$positive)/$total);
      } else {
        $score = 0;
      }
      if ($total < 5) {
         return 'Unproven';
      }
      if ($score < 25) {
        return 'Very Low';
      }
      if ($score < 50) {
        return 'Low';
      }
      if ($score < 75) {
        return 'Medium';
      }
      return "High";
    }
}
