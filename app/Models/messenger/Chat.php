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

    public static function getChat()
    {
        $data = self::get();
        return $data;
    }

    public static function insertChat($chatName, $chatType)
    {
        $model = self::create(['chat_name' => $chatName, 'chat_type' => $chatType]);
        return $model;
    }
}
