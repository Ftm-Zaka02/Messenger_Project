<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;


class MessageController extends Controller
{
    public function set(Request $request)
    {
        $chatName = $request->input('activeChatList');
        $messageText = strip_tags(trim($request->input('dialogMessage')));
        $currentTime = time();
        if (!empty($messageText)) {
            try {
                $model = Message::create(['text_message' => $messageText, 'send_time' => $currentTime, 'user_id' => 191, 'chat_name' => $chatName]);
                $res = json_encode([
                    'status' => 'success',
                    'data' => $model,
                ]);
                return response($res, 200);
            } catch (\Exception $error) {
                error_log('insert.php => ' . $error->getMessage() . "\n", 3, "err.txt");
                $res = json_encode([
                    'status' => 'error',
                    'message' => $error->getMessage(),
                ]);
                return response($res, 500);
            }
        }
    }

    public function delete(Request $request)
    {
        $dataID = $request->input('dataID');
        $deleteType = $request->input('deleteType');
        switch ($deleteType) {
            case 'physicalDelete':
            {
                if (!empty($dataID)) {
                    try {
                        $model = Message::find($dataID)->delete();
                        $res = json_encode([
                            'status' => 'success',
                            'data' => $model,
                        ]);
                        return response($res, 200);
                    } catch (\Exception $error) {
                        error_log($error->getMessage() . "\n", 3, "err.txt");
                        $res = json_encode([
                            'status' => 'error',
                            'message' => $error->getMessage(),
                        ]);
                        return response($res, 500);
                    }
                }
                break;
            }
            case 'softDelete':
            {
                if (!empty($dataID)) {
                    try {
                        $model = Message::find($dataID)->delete();
                        $res = json_encode([
                            'status' => 'success',
                            'data' => $model,
                        ]);
                        return response($res, 200);
                    } catch (\Exception $error) {
                        error_log($error->getMessage() . "\n", 3, "err.txt");
                        $res = json_encode([
                            'status' => 'error',
                            'message' => $error->getMessage(),
                        ]);
                        return response($res, 500);
                    }
                }
                break;
            }
            case 'integrated':
            {
                $chatListName = 'farawin';
                if (!empty($chatListName)) {
                    try {
                        $model = Message::where('chat_name', $chatListName)->delete();
                        $res = json_encode([
                            'status' => 'success',
                            'data' => $model,
                        ]);
                        return response($res, 200);
                    } catch (\Exception $error) {
                        error_log('delete.php => ' . $error->getMessage() . "\n", 3, "err.txt");
                        $res = json_encode([
                            'status' => 'error',
                            'message' => $error->getMessage(),
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
        $dataID = strip_tags(trim($request->input('dataID')));
        $newMessage = strip_tags(trim($request->input('newMessage')));
        if (!empty($dataID)) {
            try {
                $model = Message::find($dataID)->update(['text_message' => $newMessage]);
                $res = json_encode([
                    'status' => 'success',
                    'data' => $model,
                ]);
                return response($res, 200);
            } catch (\Exception $error) {
                error_log('update.php => ' . $error->getMessage() . "\n", 3, "err.txt");
                $res = json_encode([
                    'status' => 'error',
                    'message' => $error->getMessage(),
                ]);
                return response($res, 500);
            }
        }
    }

    public function get(int $uploaded = 0)
    {
        $result = [];
        try {
            $model = Message::orderBy('send_time')->get();
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
            $res = json_encode([
                'status' => 'error',
                'message' => $error->getMessage(),
            ]);
            return response($res, 500);
        }
    }
}
