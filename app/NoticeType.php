<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoticeType extends Model
{
    protected $fillable = ['name', 'user_id'];

    public function notices(){
        return $this->hasMany(Notice::class)->orderBy('created_at', 'DESC')->take(3);
    }
}
