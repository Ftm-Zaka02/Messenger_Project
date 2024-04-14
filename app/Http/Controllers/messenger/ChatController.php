<?php

namespace App\Http\Controllers\messenger;

use App\Http\Controllers\Controller;
use App\Models\messenger\Chat;
use Illuminate\Http\Request;
use App\Http\Requests\validator\chats\SearchChatRequest;
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
