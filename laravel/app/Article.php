<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'body',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes', 'article_id', 'user_id')->withTimestamps();
    }

    public function isLikedBy(?User $user): bool
    {
        return $user
        ? (bool) $this->likes->where('id', $user->id)->count()
        : false;
    }

    public function getCountLikesAttribute(): int
    {
        return $this->likes->count();
    }
}
