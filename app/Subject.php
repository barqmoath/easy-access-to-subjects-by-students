<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{

    protected $table = 'subjects';
    protected $fillable = [
      'stage_id','department_id','slug','subject_name','teacher_name','discription','cover'
    ];


  /*
   * BelongsTo Functions
   */
  public function department(){ return $this->belongsTo('App\Department'); }
  public function stage(){ return $this->belongsTo('App\Stage'); }

  /*
   * HasMany Functions
   */
  public function items(){ return $this->hasMany('App\Item'); }
}
