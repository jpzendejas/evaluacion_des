<?php

namespace App\Imports;

use App\GovernmentAgency;
use Maatwebsite\Excel\Concerns\ToModel;

class GovernmentAgencyImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new GovernmentAgency([
          'government_agency'=>$row[0],
        ]);
    }
}
