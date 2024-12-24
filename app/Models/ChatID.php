<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatID extends Model
{
    protected $fillable = [
        'from_id',
        'to_id'
    ];
    public function from_user()
    {
        return $this->belongsTo(User::class, 'from_id');
    }
    public function to_user()
    {
        return $this->belongsTo(User::class, 'to_id');
    }
    public function messages()
    {
        return $this->hasMany(Message::class, 'chat_id');
    }
}
