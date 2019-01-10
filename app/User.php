<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';
    protected $fillable = [
      'email', 'password','state','role','department_id','stage_id','name','photo','facebook_link'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



     /**
      * HasMany Functions
      */
      public function items(){ return $this->hasMany('App\Item'); }
      public function bags(){ return $this->hasMany('App\Bag'); }
      public function orders(){ return $this->hasMany('App\Order'); }
      public function likes(){ return $this->hasMany('App\Like'); }
      public function comments(){ return $this->hasMany('App\Comment'); }

}
