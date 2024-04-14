<?php

namespace App\Http\Controllers\messenger;

use App\Http\Controllers\Controller;
use App\Http\Requests\validator\messages\DeleteMessageRequest;
use App\Http\Requests\validator\messages\SetMessageRequest;
use App\Http\Requests\validator\messages\UpdateMessageRequest;
use App\Http\Requests\validator\messages\UploadFileRequest;
use App\Http\Requests\validator\messages\GetMessageRequest;
use App\Models\messenger\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class MessageController extends Controller
{
    public static function uploadFile(UploadFileRequest $request)
    {
        $data = $request->validated();
        $fileToUpload = $data['fileToUpload'];
        $fileName = $fileToUpload->getClientOriginalName();
        $userID = Auth::user()->getAuthIdentifier();
        $chatID = $data['chatID'];
        try {
            $fileToUpload->storeAs('public/uploaded', $fileName);
            $model = Message::uploadFile($fileName, $userID, $chatID);
            $response = json_encode([
                'status' => 'success',
                'data' => $model
            ]);
            return response($response, 200);
        } catch (\Exception $error) {
            Log::error('getting messages got error: ' . $error->getMessage());
            $response = json_encode([
                'status' => 'error',
                'message' => $error->getMessage(),
            ]);
            return response($response, 500);
        }
    }

    public function set(SetMessageRequest $request)
    {
        $data = $request->validated();
        $userID = Auth::user()->getAuthIdentifier();
        $chatID = $data['chatID'];
        $messageText = strip_tags(trim($data['dialogMessage']));
        try {
            $model = Message::insertMessage($chatID, $messageText, $userID);
            $response = json_encode([
                'status' => 'success',
                'data' => $model,
            ]);
            return response($response, 200);
        } catch (\Exception $error) {
            Log::error('creating message got error: ' . $error->getMessage());
            $response = json_encode([
                'status' => 'error',
                'message' => $error->getMessage(),
            ]);
            return response($response, 500);
        }
    }

    public function get(GetMessageRequest $request)
    {
        $page = $request->input('page');
        $chatID = $request->input('chatID');
        try {
            $model = Message::getMessage($page,$chatID);
            foreach ($model as $message) {
                if ($message['content_name']) {
                    $message['content_name'] = 'storage/uploaded/' . $message['content_name'];
                }
            }
            $response = json_encode([
                'status' => 'success',
                'data' => $model
            ]);
            return response($response, 200);
        } catch (\Exception $error) {
            Log::error('getting messages got error: ' . $error->getMessage());
            $response = json_encode([
                'status' => 'error',
                'message' => $error->getMessage(),
            ]);
            return response($response, 500);
        }
    }

    public function delete(DeleteMessageRequest $request)
    {
        $data = $request->validated();
        $deleteType = $data['deleteType'];
        switch ($deleteType) {
            case 'physicalDelete':
            {
                $dataID = $data['dataID'];
                if (!empty($dataID)) {
                    try {
                        $model = Message::physicalDeleteMessage($dataID);
                        $response = json_encode([
                            'status' => 'success',
                            'data' => $model,
                        ]);
                        return response($response, 200);
                    } catch (\Exception $error) {
                        Log::error('deleting message got error: ' . $error->getMessage());
                        $response = json_encode([
                            'status' => 'error',
                            'message' => $error->getMessage(),
                        ]);
                        return response($response, 500);
                    }
                }
                break;
            }
            case 'softDelete':
            {
                $dataID = $data['dataID'];
                if (!empty($dataID)) {
                    try {
                        $model = Message::softDeleteMessage($dataID);
                        $response = json_encode([
                            'status' => 'success',
                            'data' => $model,
                        ]);
                        return response($response, 200);
                    } catch (\Exception $error) {
                        Log::error('deleting message got error: ' . $error->getMessage());
                        $response = json_encode([
                            'status' => 'error',
                            'message' => $error->getMessage(),
                        ]);
                        return response($response, 500);
                    }
                }
                break;
            }
            case 'integrated':
            {
                $chatListName = $data['chatListName'];
                if (!empty($chatListName)) {
                    try {
                        $model = Message::chatHistoryDelete($chatListName);
                        $response = json_encode([
                            'status' => 'success',
                            'data' => $model,
                        ]);
                        return response($response, 200);
                    } catch (\Exception $error) {
                        Log::error('deleting history got error: ' . $error->getMessage());
                        $response = json_encode([
                            'status' => 'error',
                            'message' => $error->getMessage(),
                        ]);
                        return response($response, 500);
                    }
                }
                break;
            }
        }
    }

    public function update(UpdateMessageRequest $request)
    {
        $data = $request->validated();
        $dataID = strip_tags(trim($data['dataID']));
        $newMessage = strip_tags(trim($data['newMessage']));
        try {
            $model = Message::updateMessage($dataID, $newMessage);
            $response = json_encode([
                'status' => 'success',
                'data' => $model,
            ]);
            return response($response, 200);
        } catch (\Exception $error) {
            Log::error('updating message got error: ' . $error->getMessage());
            $response = json_encode([
                'status' => 'error',
                'message' => $error->getMessage(),
            ]);
            return response($response, 500);
        }

    }
}
