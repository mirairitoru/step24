<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AdoptionMatch extends Model
{
    protected $table = 'matches';

    protected $fillable = [
        'animal_id',
        'user_id',
        'animal_id',
        'status',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function chat()
    {
        return $this->hasOne(Chat::class,'match_id');
    }
}
