<?php

namespace App\Models\messenger;

use App\Events\DeleteFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Message extends Model
{
    use SoftDeletes;

    protected $connection = "mysql";
//    protected $connection = "pgsql";
    protected $table = 'messages';
    protected $fillable = ['text_message', 'send_time', 'user_id', 'chat_id', 'content_name', 'deleted_at'];

    public static function insertMessage($chatID, $messageText, $userID)
    {
        $currentTime = time();
        $model = self::create(['text_message' => $messageText, 'send_time' => $currentTime, 'user_id' => $userID, 'chat_id' => $chatID]);
        return $model;
    }

    public static function updateMessage($dataID, $newMessage)
    {
        $model = self::find($dataID);
        $model->update(['text_message' => $newMessage]);
        return $model;
    }

    public static function physicalDeleteMessage($dataID)
    {
        $model = self::find($dataID);
        if ($model['content_name']) {
            event(new DeleteFile($model));
        } else {
            $model->forceDelete();
        }
        return $model;
    }

    public static function softDeleteMessage($dataID)
    {
        $model = self::find($dataID);
        $model->delete();
        return $model;
    }

    public static function chatHistoryDelete($chatListName)
    {
        $model = self::where('chat_name', $chatListName);
        $model->forceDelete();
        return $model;
    }

    public static function getMessage($page)
    {
        $dataPage = self::paginate(5, ['*'], 'page', $page);
        return $dataPage;
    }

    public static function uploadFile($name, $userID, $chatName)
    {
        $model = self::create(['content_name' => $name, 'send_time' => time(), 'user_id' => $userID, 'chat_name' => $chatName]);
        return $model;
    }
}
