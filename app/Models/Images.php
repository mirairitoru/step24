<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    protected $fillable = [
        'path',
        'sort_order'
    ];

    public function imageable()
    {
        return $this->morphTo();
    }
}
