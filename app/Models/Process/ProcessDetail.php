<?php

namespace App\Models\Process;

use App\Models\User;
use App\Models\Process\Process;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProcessDetail extends Model
{
    use HasFactory;

    protected $table = 'process_details';

    protected $fillable = [
        'check_type','rt_number','account_number','account_name','contcode','form_type','quantity','process_id','user_id'
    ] ;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function process(){
        return $this->belongsTo(Process::class);
    }
}
