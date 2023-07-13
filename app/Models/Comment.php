<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'post_id', 'user_id', 'commenets_content'
    ];

    /**
     * Get the commentator that owns the Comment
     * 
     * return \ILLuminate\Database\ELoquent\ReLations\BeLongsTo
     */
    public function commentator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
}
