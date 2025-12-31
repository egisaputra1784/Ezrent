<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    protected $table = 'kategori';

    protected $fillable = [
        'owner_id',
        'nama_kategori',
    ];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function produk()
    {
        return $this->hasMany(Produk::class);
    }
}
