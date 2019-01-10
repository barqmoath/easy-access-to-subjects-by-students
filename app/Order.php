<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
  protected $table = 'orders';
  protected $fillable = [
    'user_id','order_content'
  ];


  public function user(){ return $this->belongsTo('App\User'); }
}
