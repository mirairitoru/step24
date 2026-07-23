<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MessageRead extends Model
{
    protected $fillable = [
        'message_id',
        'reader_type',
        'reader_id',
        'read_at',
    ];

    // メッセージ
    public function message():BelongsTo
    {
        return $this->belongsTo(Message::class);
    }

    public function reader()
    {
        return $this->morphTo(null, 'reader_type', 'reader_id');
    }
}
