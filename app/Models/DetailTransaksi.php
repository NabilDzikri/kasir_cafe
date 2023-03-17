<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    use HasFactory;
    public $table = 'detail_transaksi';

    protected $fillable = [
        'id_transaksi',
        'id_menu',
        'harga',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
