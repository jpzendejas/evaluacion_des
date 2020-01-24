<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    public function question(){
      return $this->belongsTo('App\Question');
    }
    public function answer(){
      return $this->belongsTo('App\Answer');
    }



}
