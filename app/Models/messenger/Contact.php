<?php

namespace App\Models\messenger;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $connection = "mysql";
    protected $table = 'contacts';
    protected $fillable = ['phone', 'name', 'deleted_at'];

    public static function setContact($phone, $name)
    {
        $model = self::create(['phone' => $phone, 'name' => $name]);
        return $model;
    }

    public static function getContact()
    {
        $data = self::get();
        return $data;
    }
}
