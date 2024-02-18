<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;


class MessageController extends Controller
{
    public function set(Request $request)
    {
        var_dump($request->all());
        $chat_name = $request->input('activeChatlist');
        $messageText = strip_tags(trim($request->input('dialog__message')));
        $currentTime = Message::CreateTime();

        if (!empty($messageText)) {
            try {
                Message::create(['text_message' => $messageText, 'send_time' => $currentTime, 'user_id' => 191, 'chat_name' => $chat_name, 'deleted' => 0]);
                header('Content-Type: application/json');
                http_response_code(200);
                return view('response', ['res' => json_encode([
                    'status' => 'success',
                ])]);
            } catch (\Exception $err) {
                header('Content-Type: application/json');
                http_response_code(500);
                error_log('insert.php => ' . $err->getMessage() . "\n", 3, "err.txt");
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
                        Message::find($id)->delete();
                        header('Content-Type: application/json');
                        http_response_code(200);
                        $res = json_encode([
                            'status' => 'success',
                            'message' => 'deleted...',
                        ]);
                        return response($res, 200);
                    } catch (\Exception $err) {
                        error_log($err->getMessage() . "\n", 3, "err.txt");
                        $res = json_encode([
                            'status' => 'failed',
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
                        Message::find($id)->update(['deleted' => '1']);
                        $res = json_encode([
                            'status' => 'success',
                            'message' => 'deleted...',
                        ]);
                        return response($res, 200);
                    } catch (\Exception $err) {
                        error_log($err->getMessage() . "\n", 3, "err.txt");
                        $res = json_encode([
                            'status' => 'failed',
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
                        Message::where('chat_name', $chatlistName)->delete();
                        header('Content-Type: application/json');
                        http_response_code(200);
                        return view('response', ['res' => json_encode([
                            'status' => 'success',
                            'message' => 'deleted...',
                        ])]);
                    } catch (\Exception $err) {
                        header('Content-Type: application/json');
                        http_response_code(500);
                        error_log('delete.php => ' . $err->getMessage() . "\n", 3, "err.txt");
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
                Message::find($id)->update(['text_message' => $newMessage]);
                $res = json_encode([
                    'status' => 'success',
                    'data' => $newMessage,
                ]);
                return response($res, 200);
            } catch (\Exception $err) {
                error_log('update.php => ' . $err->getMessage() . "\n", 3, "err.txt");
                $res = json_encode([
                    'status' => 'failed',
                ]);
                return response($res, 500);
            }
        }
    }

    public function get(int $uploaded = 0)
    {
        $result = [];
        try {
            $messages = Message::where('deleted', 0)->orderBy('send_time')->get()->toArray();
            foreach ($messages as $message) {
                array_push($result, $message['text_message']);
            }
            $res = json_encode([
                'status' => 'success',
                'message' => '',
                'data' => $messages
            ]);
            return response($res, 200);
        } catch (\Exception $err) {
            error_log('fetch.php => ' . $err->getMessage() . "\n", 3, "err.txt");
            $res = json_encode([
                'status' => 'failed',
            ]);
            return response($res, 500);
        }
    }
}
