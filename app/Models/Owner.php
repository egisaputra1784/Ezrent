<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $table = 'owner';

    protected $fillable = [
        'nama_usaha',
        'serial_number',
        'status',
        'expired_at',
    ];
}
