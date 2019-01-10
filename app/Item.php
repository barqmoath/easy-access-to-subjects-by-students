<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';
    protected $fillable = [
        'user_id',
        'stage_id',
        'department_id',
        'subject_id',
        'category_id',
        'item_year',
        'title',
        'discription',
        'file'
      ];


   /**
    * BelongsTo Functions
    */
   public function user(){ return $this->belongsTo('App\User'); }
   public function stage(){ return $this->belongsTo('App\Stage'); }
   public function department(){ return $this->belongsTo('App\Department'); }
   public function subject() {return $this->belongsTo('App\Subject'); }
   public function category() { return $this->belongsTo('App\Category'); }

   /**
    * HasMany Functions
    */
   public function likes(){ return $this->hasMany('App\Like'); }
   public function bags(){ return $this->hasMany('App\Bag'); }
   public function comments(){ return $this->hasMany('Comment'); }


}
