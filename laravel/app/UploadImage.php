<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadImage extends Model
{
    //upload_imagesテーブルと連携する
    protected $table = "upload_images";
    //後にcreate()メソッドで保存するカラムを指定
    protected $fillable = [
        'file_name', 'file_path', 'user_id',
    ];

    /**
     * この画像を所有するユーザ。（ Userモデルとの関係を定義）
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
