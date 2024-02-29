<?php

namespace App\Models\messenger;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Message extends Model
{
    use SoftDeletes;

    protected $connection = "mysql";
    protected $table = 'messages';
    protected $fillable = ['text_message', 'send_time', 'user_id', 'chat_type', 'chat_name', 'deleted_at'];

    public static function insertMessage($chatName, $messageText)
    {
        $currentTime = time();
        $model = self::create(['text_message' => $messageText, 'send_time' => $currentTime, 'user_id' => 191, 'chat_name' => $chatName]);
        return $model;
    }

    public static function updateMessage($dataID, $newMessage)
    {
        $model = self::find($dataID)->update(['text_message' => $newMessage]);
        return $model;
    }

    public static function physicalDeleteMessage($dataID)
    {
        $model = self::find($dataID)->forceDelete();
        return $model;
    }

    public static function softDeleteMessage($dataID)
    {
        $model = self::find($dataID)->delete();
        return $model;
    }

    public static function chatHistoryDelete($chatListName)
    {
        $model = self::where('chat_name', $chatListName)->forceDelete();
        return $model;
    }

    public static function getMessage($uploaded)
    {
        $count = self::count() / 5;
        if ($uploaded <= $count) {
            $dataPage = self::orderBy('send_time', 'desc')->paginate(5, ['*'], 'page', $uploaded);
            return $dataPage;
        }
    }
}
