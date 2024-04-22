<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
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
    public static function searchChat($searchKey)
    {
        $data = self::where('chat_name', 'LIKE', '%' . $searchKey . '%')->get();
        return $data;
    }
    protected function chatName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucwords($value),
        );
    }
}
