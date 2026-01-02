<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['customer_id',
    'bulan',
    'tahun',
    'nominal',
    'tanggal_bayar',
    'metode'];

    public function customer() {
        return $this->belongsTo(Customer::class);
    }
}
