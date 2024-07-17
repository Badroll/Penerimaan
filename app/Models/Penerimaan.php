<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penerimaan extends Model
{
    use HasFactory;

    
    protected $fillable = [
        'no_penerimaan',
        'no_invoice',
        'foto_path',
        'supplier',
        'tanggal',
        'berat_real',
        'berat_kotor',
        'berat_timbangan',
        'berat_selisih',
        'catatan',
        'pengirim',
        'pic',
        'tipe_pembayaran',
        'harga_beli',
        'tanggal_tempo'
    ];
    

    public function items()
    {
        return $this->hasMany(Item::class);
    }

}
