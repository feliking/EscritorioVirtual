<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = ['option_id', 'name', 'description', 'document', 'user_id'];

    public function option(){
        return $this->belongsTo(Option::class);
    }
}
