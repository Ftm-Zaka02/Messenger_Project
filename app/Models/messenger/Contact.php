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

    public static function setContact($data)
    {
        $model = self::create($data);
        return $model;
    }

    public static function updateContact($newData, $dataID)
    {
        $model = self::find($dataID)->update(['name' => $newData]);
        return $model;
    }

    public static function getContact()
    {
        $data = self::get();
        return $data;
    }
}
