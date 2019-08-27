<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    protected $fillable = ['user_id', 'notice_type_id', 'title', 'description', 'document', 'img'];

    public function notice_type(){
        return $this->belongsTo(NoticeType::class);
    }
}
