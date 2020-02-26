<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = ['token','employee_name','government_agency_id','parent_token'];
    public function government_agency(){
      return $this->belongsTo('App\GovernmentAgency');
    }

    public function question_answer()
    {
        return $this->hasMany('App\EmployeeQuestionAnswer');
    }
}
