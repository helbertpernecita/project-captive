<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sample extends Model
{
    use HasFactory;

    protected $table = "samples";

    protected $fillable = [
        'date',
        'time', 
        'delivery_date', 
        'check_type', 
        'check_name', 
        'brstn', 
        'acccount_number', 
        'name1', 
        'name2', 
        'name3', 
        'name4', 
        'starting_serial', 
        'ending_serial', 
        'batch', 
        'final_batch', 
        'branch_code', 
        'address1', 
        'address2', 
        'address3', 
        'address4', 
        'address5', 
        'address6', 
        'hash_sent_date', 
        'hash_sent_time', 
        'packing_blob', 
        'file_name',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
