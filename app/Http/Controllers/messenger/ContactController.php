<?php

namespace App\Http\Controllers\messenger;

use App\Http\Controllers\Controller;
use App\Models\messenger\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public static function set(Request $request)
    {
        $phone=$request['phone'];
        $name=$request['name'];
        try {
            $model = Contact::setContact($phone,$name);
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

    public static function get()
    {
    }
}
