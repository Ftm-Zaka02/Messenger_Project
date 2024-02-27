<?php

namespace App\Http\Controllers;

use App\Http\Requests\validator\messages\DeletePostRequest;
use App\Http\Requests\validator\messages\SetPostRequest;
use App\Http\Requests\validator\messages\UpdatePostRequest;
use App\Http\Requests\validator\messages\UploadFileRequest;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public static function uploadFile(UploadFileRequest $request)
    {
        $validated = $request->validated();
        $fileToUpload = $validated['fileToUpload'];
        $fileName = $fileToUpload->getClientOriginalName();
        try {
            $path = $fileToUpload->storeAs('public/uploaded', $fileName);
            $response = json_encode([
                'status' => 'success',
                'data' => $path
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

    public function set(SetPostRequest $request)
    {
        $validated = $request->validated();
        $chatName = $validated['activeChatList'];
        $messageText = strip_tags(trim($validated['dialogMessage']));
        try {
            $model = Message::insertMessage($chatName, $messageText);
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

    public function delete(DeletePostRequest $request)
    {
        $validated = $request->validated();
        $deleteType = $validated['deleteType'];
        switch ($deleteType) {
            case 'physicalDelete':
            {
                $dataID = $validated['dataID'];
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
                $dataID = $validated['dataID'];
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
                $chatListName = $validated['chatListName'];
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

    public function update(UpdatePostRequest $request)
    {
        $validated = $request->validated();
        $dataID = strip_tags(trim($validated['dataID']));
        $newMessage = strip_tags(trim($validated['newMessage']));
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

    public function get(Request $request)
    {
        $uploaded = $request->input('uploaded');
        try {
            $model = Message::getMessage($uploaded);
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
}
