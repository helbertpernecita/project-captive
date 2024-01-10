<?php

namespace App\Models;

use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChinaBankProcess extends Model
{
    use HasFactory;

    protected $table = 'china_bank_processes';
    protected $fillable = [
        'check_type', //TODO: What are type of checks?
        'rt_number', //routing transit number
        'account_number', // account number
        'account_name', //account name
        'contcode', // TODO: what ss cont code?
        'form_type', // TODO: what are the form types?
        'quantity', // number og booklet
        'user_id', //user
        'client_id', //bank
        'isProcessed', //false
    ] ;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }
}
