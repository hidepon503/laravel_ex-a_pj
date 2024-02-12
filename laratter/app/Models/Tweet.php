<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tweet extends Model
{
    use HasFactory;
    protected $fillable = ['tweet'];
    //上のコードは、ユーザーがツイートを作成するときに、ツイートの内容をデータベースに保存するためのものです。

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function liked()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
