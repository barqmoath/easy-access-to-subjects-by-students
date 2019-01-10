<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bag extends Model
{

  protected $table = 'bags';
  protected $fillable = [
    'user_id','item_id'
  ];

  public function user() { return $this->belongsTo('App\User'); }
  public function item() { return $this->belongsTo('App\Item'); }
}
