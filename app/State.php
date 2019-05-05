<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['name'];

    public function counties()
    {
        return $this->hasMany(County::class);
    }
}
