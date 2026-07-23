<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\Favorite;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_name',
        'nickname',
        'email',
        'password',
        'user_age',
        'residence_area',
        'animal_care_experience',
        'animal_care_details',
        'self_introduction',
    ];

    protected $hidden = [
        'password'
    ];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function matches()
    {
        return $this->hasMany(AdoptionMatch::class);
    }

    public function image()
    {
        return $this->morphOne(
            Images::class,
            'imageable'
        );
    }
}
