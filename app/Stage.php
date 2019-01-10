<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Stage extends Model
{
    protected $table = 'stages';
    protected $fillable = [
      'department_id','stage_name'
    ];


  /**
   * BelongsTo Functions
   */
  public function department(){ return $this->belongsTo('App\Department'); }

  /*
   * HasMany Functions
   */
  public function subjects(){ return $this->hasMany('App/Subject'); }
  public function items(){ return $this->hasMany('App/Item'); }
}
