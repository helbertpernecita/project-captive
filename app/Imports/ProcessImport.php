<?php

namespace App\Imports;

use App\Models\Process\Process;
use Illuminate\Support\Facades\Auth;
use App\Models\Process\ProcessDetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProcessImport implements ToModel, WithHeadingRow
{

    protected $process;

    public function __construct($process)
    {
        $this->process = $process;
    }
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new ProcessDetail([
            'check_type' => $row['chktype'],
            'rt_number' => $row['rtno'],
            'account_number' => $row['acctno'],
            'account_name' => $row['acctnm12'],
            'contcode' => $row['contcode'],
            'form_type' => $row['formtype'],
            'quantity' => $row['qty'],
            'isProcessed' => 0,
            'user_id' => Auth::user()->id,
            'client_id' => $this->process->client_id,
            'process_id' => $this->process->id,
        ]);
    }
}
