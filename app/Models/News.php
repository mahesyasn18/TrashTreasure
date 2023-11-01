<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    use HasFactory;

    protected $fillable = ['title','cover','content'];

    public function tag()
    {
        return $this->belongsToMany(Tags::class, 'news_tags', 'news_id', 'tag_id');
    }

}
