<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

  protected $table = 'comments';
  protected $fillable = [
    'user_id','item_id','the_comment'
  ];

  public function user() { return $this->belongsTo('App\User'); }
  public function item() { return $this->belongsTo('App\Item'); }
}
