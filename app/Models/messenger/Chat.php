<?php

namespace App\Models\messenger;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $connection = "mysql";
    protected $table = 'chats';
    protected $fillable = ['chat_name', 'chat_type', 'deleted_at'];
}
