<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function government_agency(){
      return $this->belongsTo('App\GovernmentAgency');
    }
}
