<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paket extends Model
{
    protected $fillable = ['nama',
    'speed',
    'harga'];

    public function customers() {
        return $this->hasMany(Customer::class);
    }
}
