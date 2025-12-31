<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'owner_id',
        'user_id',
        'customer_id',
        'produk_id',
        'harga',
        'denda',
        'tanggal_sewa',
        'tanggal_kembali',
        'status',
        'jaminan_tipe',
        'jaminan_nilai',
        'jaminan_detail',
    ];

    public function produk() {
        return $this->belongsTo(Produk::class, 'produk_id');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
