<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'animal_name',
        'species',
        'age',
        'sex',
        'personality',
        'health_status',
        'comment',
        'adoption_status',
        'organization_id',
    ];

    protected $attributes = [
        'adoption_status' => '募集中',
    ];

    public const AGE_MAP = [
        'growth' => ['label' => '成長', 'sub' => '(0~1歳)'],
        'youth' => ['label' => '青年', 'sub' => '(2~5歳)'],
        'adult' => ['label' => '中年', 'sub' => '(6~9歳)'],
        'senior' => ['label' => 'シニア', 'sub' => '(10歳以上)'],
    ];

    protected $casts = [
        'personality' => 'array',
    ];

    public function getAgeLabelAttribute()
    {
        return self::AGE_MAP[$this->age]['label'] ?? null;
    }

    public function getAgeSubAttribute()
    {
        return self::AGE_MAP[$this->age]['sub'] ?? null;
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function getIsFavoritedAttribute()
    {
        if(!Auth::guard('web')->check()) {
            return false;
        }

        return $this->favorites()
            ->where('user_id', Auth::guard('web')->id())
            ->whereIn('status', ['pending', 'matched'])
            ->exists();
    }

    public function matche()
    {
        return $this->hasMany(AdoptionMatch::class);
    }

    public function images()
    {
        return $this->morphMany(
            Images::class,
            'imageable'
        );
    }

    public function topImage()
    {
        return $this->images()->orderBy('sort_order')->first();
    }

    public function getCanEditAttribute()
    {
        return
            !$this->favorites->contains('status', 'matched') &&
            !$this->matche->contains(fn ($match) =>
                in_array($match->status, ['譲渡準備中', '譲渡完了'])
            );
    }

    public function canEdit(): bool
    {
        $isMatched = $this->favorites()->where('status', 'matched')->exists();

        if($isMatched) {
            return false;
        }

        $hasMatch = $this->matche()->whereIn('status', ['譲渡準備中', '譲渡完了'])->exists();

        if($hasMatch) {
            return false;
        }

        return true;
    }
}
