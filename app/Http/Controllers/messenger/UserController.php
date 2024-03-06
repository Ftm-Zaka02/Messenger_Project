<?php

namespace App\Http\Controllers\messenger;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\messenger\User;



class UserController extends Controller
{
    public static function insert($phone,$password)
    {
        User::insertUser($phone, $password);
    }
}
