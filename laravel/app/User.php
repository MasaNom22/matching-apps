<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'gender', 'age',
    ];

    const GENDER = [
        'male' => ['label' => '男'],
        'female' => ['label' => '女'],
    ];

    public function getGenderLabelAttribute()
    {
        // 状態値
        $gender = $this->attributes['gender'];

        return self::GENDER[$gender]['label'];
    }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * このユーザが所有する画像。（ UploadImageモデルとの関係を定義）
     */
    public function uploadimages()
    {
        // return $this->hasMany(UploadImage::class);
        return $this->hasOne(UploadImage::class);
    }

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
    public function getCountArticlesAttribute(): int
    {
        return $this->articles->count();
    }
    //フォロワーがフォローしているユーザー
    public function followings()
    {
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followee_id')->withTimestamps();
    }
    //アクセサ
    public function getCountFollowingsAttribute(): int
    {
        return $this->followings->count();
    }

    //ユーザーにフォローされているフォロワー
    public function followers()
    {
        return $this->belongsToMany(User::class, 'follows', 'followee_id', 'follower_id')->withTimestamps();
    }
    public function getCountFollowersAttribute(): int
    {
        return $this->followers->count();
    }

    public function likes()
    {
        return $this->belongsToMany(Article::class, 'likes', 'user_id', 'article_id')->withTimestamps();
    }

    public function like($id)
    {
        // すでにlikeしているかの確認
        $exist = $this->is_liking($id);

        if ($exist) {
            // すでにlikeしていれば何もしない
            return false;
        } else {
            $this->likes()->attach($id);
            return true;
        }
    }

    public function unlike($id)
    {
        // すでにlikeしているかの確認
        $exist = $this->is_liking($id);

        if ($exist) {
            // すでにlikeしていればlikeeを外す
            $this->likes()->detach($id);
            return true;
        } else {
            // 未likeであれば何もしない
            return false;
        }
    }

    public function is_liking($id)
    {
        return $this->likes()->where('article_id', $id)->exists();
    }

    public function follow($id)
    {
        // すでにフォローしているかの確認
        $exist = $this->is_following($id);
        // 対象が自分自身かどうかの確認
        $its_me = $this->id == $id;

        if ($exist || $its_me) {
            // すでにフォローしていれば何もしない
            return false;
        } else {
            // 未フォローであればフォローする
            $this->followings()->attach($id);
            return true;
        }
    }

    public function unfollow($id)
    {
        // すでにフォローしているかの確認
        $exist = $this->is_following($id);
        // 対象が自分自身かどうかの確認
        $its_me = $this->id == $id;

        if ($exist && !$its_me) {
            // すでにフォローしていればフォローを外す
            $this->followings()->detach($id);
            return true;
        } else {
            // 未フォローであれば何もしない
            return false;
        }
    }
    public function is_following($id)
    {
        //すでにフォロー中であるかどうか
        return $this->followings()->where('followee_id', $id)->exists();
    }

    public function isFollowedBy(?User $user): bool
    {
        return $user
        ? (bool) $this->followers->where('id', $user->id)->count()
        : false;
    }

    public function follow_each()
    {
        //ユーザがフォロー中のユーザを取得
        $userIds = $this->followings()->pluck('users.id')->toArray();
        //相互フォロー中のユーザを取得
        $follow_each = $this->followers()->whereIn('users.id', $userIds)->pluck('users.id')->toArray();
        //相互フォロー中のユーザを返す
        return $follow_each;
    }
}
