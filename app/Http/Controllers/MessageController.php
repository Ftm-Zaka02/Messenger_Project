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
        if (!empty($messageText)) {
            try {
                $model=Message::insertMessage($chatName,$messageText);
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
        $chatListName = $request->input('activeChatList');
        switch ($deleteType) {
            case 'physicalDelete':
            {
                if (!empty($dataID)) {
                    try {
                        $model=Message::physicalDeleteMessage($dataID);
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
                        $model = Message::softDeleteMessage($dataID);
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
                if (!empty($chatListName)) {
                    try {
                        $model=Message::chatHistoryDelete($chatListName);
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
                $model=Message::updateMessage($dataID,$newMessage);
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
            $model = Message::getMessage($uploaded);
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
