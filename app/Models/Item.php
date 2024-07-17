<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'penerimaan_id',
        'karat',
        'berat_real',
        'berat_kotor',
    ];
    

    public function penerimaan()
    {
        return $this->belongsTo(Penerimaan::class);
    }

}
