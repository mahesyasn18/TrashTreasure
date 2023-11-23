<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenukaranSampah extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','jumlah_sampah','jumlah_point'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
