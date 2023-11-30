<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenukaranPoin extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'jumlah_poin', 'jumlah_uang'];

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
