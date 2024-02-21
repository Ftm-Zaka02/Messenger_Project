<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;


class MessageController extends Controller
{
    public function set(Request $request)
    {
        $chat_name = $request->input('activeChatlist');
        $messageText = strip_tags(trim($request->input('dialog__message')));
        $currentTime = Message::CreateTime();
        if (!empty($messageText)) {
            try {
                $model=Message::create(['text_message' => $messageText, 'send_time' => $currentTime, 'user_id' => 191, 'chat_name' => $chat_name, 'deleted' => 0]);
                $res=json_encode([
                    'status' => 'success',
                    'data'=>$model,
                ]);
                return response($res, 200);
            } catch (\Exception $error) {
                error_log('insert.php => ' . $error->getMessage() . "\n", 3, "err.txt");
                $res=json_encode([
                    'status' => 'error',
                    'message'=>$error->getMessage(),
                ]);
                return response($res, 500);
            }
        }
    }

    public function delete(Request $request)
    {
        $id = $request->input('dataID');
        $deleteType = $request->input('deleteType');
        switch ($deleteType) {
            case 'physicalDelete':
            {
                if (!empty($id)) {
                    try {
                        $model=Message::find($id)->delete();
                        $res = json_encode([
                            'status' => 'success',
                            'data' => $model,
                        ]);
                        return response($res, 200);
                    } catch (\Exception $error) {
                        error_log($error->getMessage() . "\n", 3, "err.txt");
                        $res=json_encode([
                            'status' => 'error',
                            'message'=>$error->getMessage(),
                        ]);
                        return response($res, 500);
                    }
                }
                break;
            }
            case 'softDelete':
            {
                if (!empty($id)) {
                    try {
                        $model=Message::find($id)->update(['deleted' => '1']);
                        $res = json_encode([
                            'status' => 'success',
                            'data' => $model,
                        ]);
                        return response($res, 200);
                    } catch (\Exception $error) {
                        error_log($error->getMessage() . "\n", 3, "err.txt");
                        $res=json_encode([
                            'status' => 'error',
                            'message'=>$error->getMessage(),
                        ]);
                        return response($res, 500);
                    }
                }
                break;
            }
            case 'integrated':
            {
                $chatlistName = 'farawin';
                if (!empty($chatlistName)) {
                    try {
                        $model=Message::where('chat_name', $chatlistName)->delete();
                        $res = json_encode([
                            'status' => 'success',
                            'data' => $model,
                        ]);
                        return response($res, 200);
                    } catch (\Exception $error) {
                        error_log('delete.php => ' . $error->getMessage() . "\n", 3, "err.txt");
                        $res=json_encode([
                            'status' => 'error',
                            'message'=>$error->getMessage(),
                        ]);
                        return response($res, 500);
                    }
                }
                break;
            }
        }
    }

    public function update(Request $request)
    {
        $id = strip_tags(trim($request->input('dataID')));
        $newMessage = strip_tags(trim($request->input('newMessage')));
        if (!empty($id)) {
            try {
                $model=Message::find($id)->update(['text_message' => $newMessage]);
                $res = json_encode([
                    'status' => 'success',
                    'data' => $model,
                ]);
                return response($res, 200);
            } catch (\Exception $error) {
                error_log('update.php => ' . $error->getMessage() . "\n", 3, "err.txt");
                $res=json_encode([
                    'status' => 'error',
                    'message'=>$error->getMessage(),
                ]);
                return response($res, 500);
            }
        }
    }

    public function get(int $uploaded = 0)
    {
        $result = [];
        try {
            $model = Message::where('deleted', 0)->orderBy('send_time')->get()->toArray();
            foreach ($model as $message) {
                array_push($result, $message['text_message']);
            }
            $res = json_encode([
                'status' => 'success',
                'data' => $model
            ]);
            return response($res, 200);
        } catch (\Exception $error) {
            error_log('fetch.php => ' . $error->getMessage() . "\n", 3, "err.txt");
            $res=json_encode([
                'status' => 'error',
                'message'=>$error->getMessage(),
            ]);
            return response($res, 500);
        }
    }
}
