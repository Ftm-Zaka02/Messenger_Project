<?php

namespace App\Http\Controllers;

use App\Models\Message;


class MessageController extends Controller
{
    public function set($text, $chat_name)
    {
        $messageText = strip_tags(trim($text));
        $currentTime = Message::CreateTime();

        if (!empty($messageText)) {
            try {
                Message::create(['text_message' => $messageText, 'send_time' => $currentTime,'user_id' => 191, 'chat_name' => $chat_name, 'deleted' => 0]);
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

    public function delete($id, $deleteType)
    {
        switch ($deleteType) {
            case 'physicalDelete':
            {
                if (!empty($id)) {
                    try {
                        Message::find($id)->delete();
                        header('Content-Type: application/json');
                        http_response_code(200);
                        return view('response', ['res' => json_encode([
                            'status' => 'success',
                            'message' => 'deleted...',
                        ])]);

                    } catch (\Exception $err) {
                        header('Content-Type: application/json');
                        http_response_code(500);
                        error_log($err->getMessage() . "\n", 3, "err.txt");
                    }
                }
                break;
            }
            case 'softDelete':
            {
                if (!empty($id)) {
                    try {
                        dd(Message::find($id)->update(['deleted' => '1']));
                        header('Content-Type: application/json');
                        http_response_code(200);
                        echo json_encode([
                            'status' => 'success',
                            'messageSeeder' => 'deleted...',
                        ]);
                    } catch (\Exception $err) {
                        header('Content-Type: application/json');
                        http_response_code(500);
                        error_log($err->getMessage() . "\n", 3, "err.txt");
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

    public function update($id, $newMessage)
    {
        $id = strip_tags(trim($id));
        $newMessage = strip_tags(trim($newMessage));

        if (!empty($id)) {
            try {
                Message::find($id)->update(['text_message' => $newMessage]);
                header('Content-Type: application/json');
                http_response_code(200);
                return view('response', ['res' => json_encode([
                    'status' => 'success',
                    'data' => $newMessage,
                ])]);

            } catch (\Exception $err) {
                header('Content-Type: application/json');
                http_response_code(500);
                error_log('update.php => ' . $err->getMessage() . "\n", 3, "err.txt");
            }
        }
    }

    public function get(int $uploaded = 0)
    {
        $result=[];
        try {
//            ->take($uploaded)
            $messages = Message::where('deleted',0)->orderBy('send_time')->get()->toArray();
            foreach ($messages as $message){
                array_push($result,$message['text_message']);
            }
            header('Content-Type: application/json');
            http_response_code(200);
            return view('response', ['res' => json_encode([
                'status' => 'success',
                'message' => '',
                'data' => $messages
            ])]);

        } catch (\Exception $err) {
            header('Content-Type: application/json');
            http_response_code(500);
            error_log('fetch.php => ' . $err->getMessage() . "\n", 3, "err.txt");
        }
//        return response([], 500);
    }
}
