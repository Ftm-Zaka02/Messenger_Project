<?php

namespace App\Http\Controllers;

use App\Models\Message;

class MessageController extends Controller
{
    public function set($text, $chat)
    {
        $messageText = strip_tags(trim($text));

        if (!empty($messageText)) {
            try {
                Message::insertData($messageText, 191, $chat);
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

    public function update($id, $newMessage)
    {
        $id = strip_tags(trim($id));
        $newMessage = strip_tags(trim($newMessage));

        if (!empty($id)) {
            try {
                Message::updateData($id, 'messageSeeder', $newMessage);
                header('Content-Type: application/json');
                http_response_code(200);
                return view('response', ['res' => json_encode([
                    'status' => 'success',
                    'messageSeeder' => '',
                    'data' => $newMessage
                ])]);

            } catch (\Exception $err) {
                header('Content-Type: application/json');
                http_response_code(500);
                error_log('update.php => ' . $err->getMessage() . "\n", 3, "err.txt");
            }
        }
    }

    public function delete($id, $deleteType)
    {
        switch ($deleteType) {
            case 'single-real':
            {
                if (!empty($id)) {
                    try {
                        Message::deleteData($id);
                        header('Content-Type: application/json');
                        http_response_code(200);
                        return view('response', ['res' => json_encode([
                            'status' => 'success',
                            'messageSeeder' => 'deleted...',
                        ])]);

                    } catch (\Exception $err) {
                        header('Content-Type: application/json');
                        http_response_code(500);
                        error_log($err->getMessage() . "\n", 3, "err.txt");
                    }
                }
                break;
            }
            case 'single-physical':
            {
                if (!empty($id)) {
                    try {
                        Message::deleteDataphysical($id);
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
                $chatlistName = $data['activeChatlist'];
                if (!empty($chatlistName)) {
                    try {
                        Message::deleteChatHistory($chatlistName);
                        header('Content-Type: application/json');
                        http_response_code(200);
                        return view('response', ['res' => json_encode([
                            'status' => 'success',
                            'messageSeeder' => 'deleted...',
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
//        return view('response',['action'=>'delete']);

    }
    public function get($uploaded = 0)
    {
        try {
            $messages = Message::selectAllData($uploaded);
            header('Content-Type: application/json');
            http_response_code(200);
            return view('response', ['res' => json_encode([
                'status' => 'success',
                'messageSeeder' => '',
                'data' => $messages
            ])]);

        } catch (\Exception $err) {
            header('Content-Type: application/json');
            http_response_code(500);
            error_log('fetch.php => ' . $err->getMessage() . "\n", 3, "err.txt");
        }
        return response([],500);
    }
}
