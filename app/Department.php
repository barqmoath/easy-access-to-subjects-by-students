<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{

  protected $table = 'departments';
  protected $fillable = [
    'slug','department_name'
  ];

  public function stages(){ return $this->hasMany('App\Stage'); }
  public function subjects(){ return $this->hasMany('App\Subject'); }
  public function items(){ return $this->hasMany('App\Item'); }
}
