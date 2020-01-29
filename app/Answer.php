<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
	protected $fillable = ['answer','answer_value'];
  	public function answers(){
    return $this->belongsTo('App\QuestionAnswer');
  }
}
