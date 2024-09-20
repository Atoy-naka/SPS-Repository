<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'chat_id',
        'body',
    ];

    public function chat()
    {
        return $this->belongsTo(Room::class, 'chat_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function markAsRead()
    {
        $this->is_read = true;
        $this->save();
    }
}
