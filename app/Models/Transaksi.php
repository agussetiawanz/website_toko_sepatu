<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\DetailTransaksi;

class Transaksi extends Model
{
    protected $fillable = ['kode', 'total', 'status'];
    public function detilTransaksi()
    {
        return $this->hasMany(DetailTransaksi::class);
    }

}
