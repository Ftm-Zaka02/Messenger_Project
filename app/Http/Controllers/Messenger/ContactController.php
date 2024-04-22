<?php

namespace App\Http\Controllers\Messenger;

use App\Http\Controllers\Controller;
use App\Http\Requests\Validator\Contacts\DeleteContactRequest;
use App\Http\Requests\Validator\Contacts\SetContactRequest;
use App\Http\Requests\Validator\Contacts\UpdateContactRequest;
use App\Models\Chat;
use App\Models\Contact;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public static function set(SetContactRequest $request)
    {
        $data = $request->validated();
        try {
            $model = \App\Models\Contact::insertContact($data);
            Chat::insertChat($data['name'],'pv');
            $response = json_encode([
                'status' => 'success',
                'data' => $model
            ]);
            return response($response, 200);
        } catch (\Exception $error) {
            Log::error('setting contact got error: ' . $error->getMessage());
            $response = json_encode([
                'status' => 'error',
                'message' => $error->getMessage(),
            ]);
            return response($response, 500);
        }
    }

    public static function update(UpdateContactRequest $request)
    {
        $data = $request->validated();
        $newData = $data['firstName'] . " " . $data["lastName"];
        $dataID = $data['dataID'];
        try {
            $model = Contact::updateContact($newData, $dataID);
            $response = json_encode([
                'status' => 'success',
                'data' => $model,
            ]);
            return response($response, 200);

        } catch (\Exception $error) {
            Log::error('updating contact got error: ' . $error->getMessage());
            $response = json_encode([
                'status' => 'error',
                'message' => $error->getMessage(),
            ]);
            return response($response, 500);
        }
    }

    public static function delete(DeleteContactRequest $request)
    {
        $data = $request->validated();
        $dataID = $data['dataID'];
        try {
            $model = Contact::deleteContact($dataID);
            $response = json_encode([
                'status' => 'success',
                'data' => $model
            ]);
            return response($response, 200);
        } catch (\Exception $error) {
            Log::error('deleting contact got error: ' . $error->getMessage());
            $response = json_encode([
                'status' => 'error',
                'message' => $error->getMessage(),
            ]);
            return response($response, 500);
        }
    }

    public static function get()
    {
        try {
            $model = \App\Models\Contact::getContact();
            $response = json_encode([
                'status' => 'success',
                'data' => $model
            ]);
            return response($response, 200);
        } catch (\Exception $error) {
            Log::error('getting contact got error: ' . $error->getMessage());
            $response = json_encode([
                'status' => 'error',
                'message' => $error->getMessage(),
            ]);
            return response($response, 500);
        }
    }
}
