<?php

namespace App\Http\Controllers\messenger;

use App\Http\Controllers\Controller;
use App\Http\Requests\validator\contacts\SetContactRequest;
use App\Http\Requests\validator\contacts\UpdateContactRequest;
use App\Http\Requests\validator\contacts\DeleteContactRequest;
use App\Models\messenger\Contact;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public static function set(SetContactRequest $request)
    {
        $data = $request->validated();
        try {
            $model = Contact::setContact($data);
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
        $newData=$data['firstName']." ".$data["lastName"];
        $dataID=$data['dataID'];
        try {
            $model = Contact::updateContact($newData,$dataID);
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
    public static function get()
    {
        try {
            $model = Contact::getContact();
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
