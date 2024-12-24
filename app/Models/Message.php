<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'chat_id',
        'text',
        'image',
        'sender_id',
        'file_type',
    ];

    public function chat()
    {
        return $this->belongsTo(ChatID::class, 'chat_id');
    }
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
