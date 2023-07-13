<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use illuminate\Database\Eloquent\Relations\BelongsTo;
use illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'news_content', 'author', 'image'    
    ];

    /**
     * Get the writeng that owns the Post
     * 
     * @return \illuminate\Database\Eloquent\Relations\BeLongsTo
     */
    public function writer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }

    /**
     * The comments that belong to the Post
     * 
     * @return \illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->HasMany(Comment::class, 'post_id', 'id');
    }
}
