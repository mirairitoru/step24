<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'match_id',
        'status',
    ];

    public function match()
    {
        return $this->belongsTo(AdoptionMatch::class, 'match_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function close(): void
    {
        $this->update(['status' => 'closed']);
    }

    public function block(): void
    {
        $this->update(['status' => 'blocked']);
    }

    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
