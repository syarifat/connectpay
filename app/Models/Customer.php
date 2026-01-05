<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

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

    /**
     * Relasi ke model User (Data Login)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke model Paket
     */
    public function paket()
    {
        return $this->belongsTo(Paket::class, 'paket_id');
    }
}