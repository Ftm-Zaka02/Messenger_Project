<?php

namespace App\Http\Controllers\Messenger;

use App\Http\Controllers\Controller;
use App\Http\Requests\Validator\Chats\SearchChatRequest;
use App\Models\Chat;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public static function get()
    {
        try {
            $model = Chat::getChat();
            $response = json_encode([
                'status' => 'success',
                'data' => $model
            ]);
            return response($response, 200);
        } catch (\Exception $error) {
            Log::error('getting chat got error: ' . $error->getMessage());
            $response = json_encode([
                'status' => 'error',
                'message' => $error->getMessage(),
            ]);
            return response($response, 500);
        }
    }
    public static function search(SearchChatRequest $request)
    {
        $data = $request->validated();
        try {
            $model = Chat::searchChat($data['searchKey']);
            $response = json_encode([
                'status' => 'success',
                'data' => $model
            ]);
            return response($response, 200);
        } catch (\Exception $error) {
            Log::error('searching chat got error: ' . $error->getMessage());
            $response = json_encode([
                'status' => 'error',
                'message' => $error->getMessage(),
            ]);
            return response($response, 500);
        }
    }
}
