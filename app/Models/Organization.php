<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;

class Organization extends Authenticatable
{
    use HasFactory,Notifiable;

    protected $fillable = [
        'org_name',
        'contact_name',
        'email',
        'password',
        'location',
        'activity_description',
        'adoption_summary',
    ];

    protected $hidden = [
        'password',
    ];

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }

    public function image()
    {
        return $this->morphOne(
            Images::class,
            'imageable'
        );
    }

    public function notifications()
    {
        return $this->morphMany(
            \Illuminate\Notifications\DatabaseNotification::class,
            'notifiable'
        );
    }
}
