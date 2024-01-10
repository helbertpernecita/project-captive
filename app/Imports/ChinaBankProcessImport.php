<?php

namespace App\Imports;

use App\Models\Client;
use App\Models\ChinaBankProcess;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ChinaBankProcessImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $client = Client::where("name","like","%China Bank%")->first();

        return new ChinaBankProcess([
            'check_type' => $row['chktype'],
            'rt_number' => $row['rtno'],
            'account_number' => $row['acctno'],
            'account_name' => $row['acctnm12'],
            'contcode' => $row['contcode'],
            'form_type' => $row['formtype'],
            'quantity' => $row['qty'],
            'isProcessed' => 0,
            'user_id' => Auth::user()->id,
            'client_id' => $client->id,
        ]);
    }
}
