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
    'paket',
    'jatuh_tempo',
    'pppoe_profile',
    'foto_rumah'
];
}
