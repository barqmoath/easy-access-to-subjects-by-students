<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
  protected $table = 'likes';
  protected $fillable = [
    'user_id','item_id'
  ];


  public function user(){ return $this->belongsTo('App\User'); }
  public function item(){ return $this->belongsTo('App\Item'); }
}
