<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';

    protected $fillable = [
        'name',
        'brstn',
        'code',
        'branch',
        'address',
        'address1',
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
