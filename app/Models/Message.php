<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Message extends Model
{
    protected $fillable = [
        'chat_id',
        'sender_type',
        'sender_id',
        'message',
    ];

    // チャットルーム
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    // 既存情報
    public function reads(): HasMany
    {
        return $this->hasMany(MessageRead::class);
    }

    // 指定したユーザー/団体がこのメッセージを既読したか判定
    public function isReadBy(string $readerType): bool
    {
        return $this->reads
            ->where('reader_type', $readerType)
            ->isNotEmpty();
    }

    // 既読をつける
    public function markAsRead(string $readerType, int $readerId): void
    {
        $this->reads()->updateOrCreate(
            [
                'reader_type' => $readerType,
                'reader_id' => $readerId,
            ],
            [
                'read_at' => now(),
            ]
        );
    }
}
