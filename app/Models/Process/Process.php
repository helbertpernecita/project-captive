<?php

namespace App\Models\Process;

use App\Models\User;
use App\Models\Client;
use App\Models\Process\ProcessDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Process extends Model
{
    use HasFactory;

    protected $table = 'processes';

    protected $fillable = [
        'id','date','time','delivery_date','isProcessed','batch','final_batch','brstn','file_name','user_id','client_id'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function processDetails(){
        return $this->hasMany(ProcessDetail::class);
    }
}
