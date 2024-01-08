<?php

namespace App\Imports;

use App\Models\Sample;
use Maatwebsite\Excel\Concerns\ToModel;

class SampleImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Sample([
            //
        ]);
    }
}
