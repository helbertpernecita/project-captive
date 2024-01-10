<?php

namespace App\Imports\Process;

use App\Models\Process\Process;
use Maatwebsite\Excel\Concerns\ToModel;

class ProcessImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
   {

   }
}
