<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSampah extends Model
{
    use HasFactory;

    protected $fillable = ['jenis_sampah'];


    public function penukaranSampah()
    {
        return $this->hasMany(PenukaranSampah::class, 'jenis_sampah_id');
    }

}
