<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

trait CreateSendTime
{
    public static function CreateTime()
    {
        date_default_timezone_set("Asia/Tehran");
        $now = time();
        return $now;
    }
}

class Message extends Model
{
    use CreateSendTime;
    public $timestamps = false;
    protected $connection = "mysql";
    protected $table = 'messages';
    protected $fillable = ['text_message', 'send_time', 'user_id', 'chat_name','deleted'];
}
