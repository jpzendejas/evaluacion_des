<?php

namespace App\Imports;

use App\Employee;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeeImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Employee([
          'token'=>$row[0],
          'employee_name'=>$row[1],
          'government_agency_id'=>$row[2],
          'parent_token'=>$row[3],
        ]);
    }
}
