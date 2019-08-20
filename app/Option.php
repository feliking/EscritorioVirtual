<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    protected $fillable = ['name', 'user_id'];

    public function items(){
        return $this->hasMany(Item::class);
    }
}
