<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'user_id',
        'id_pelanggan',
        'nama',
        'nik',
        'nomor_wa',
        'alamat',
        'paket_id',
        'jatuh_tempo',
        'pppoe_profile',
        'foto_rumah'
    ];
    public function paket() {
        return $this->belongsTo(Paket::class, 'paket_id');
    }
}
