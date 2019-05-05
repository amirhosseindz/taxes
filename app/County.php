<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    protected $fillable = ['state_id', 'name', 'tax_rate', 'collected_taxes'];

    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
