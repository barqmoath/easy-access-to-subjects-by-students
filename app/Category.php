<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{

  protected $table = 'categories';
  protected $fillable = [
    'slug','category_name'
  ];


  public function items() { return $this->hasMany('App\Item'); }
}
