<?php

namespace App\Models\messenger;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Contact extends Model
{
    use HasFactory;

    protected $connection = "mysql";
    protected $table = 'contacts';
    protected $fillable = ['phone', 'name', 'deleted_at'];

    public static function insertContact($data)
    {
        $model = self::create($data);
        return $model;
    }

    public static function updateContact($newData, $dataID)
    {
        $model = self::find($dataID);
        $model->update(['name' => $newData]);
        return $model;
    }

    public static function deleteContact($dataID)
    {
        $model = self::find($dataID);
        $model->delete();
        return $model;
    }

    public static function getContact()
    {
        $data = self::get();
        return $data;
    }

    public static function searchContact($searchKey)
    {
        $data = self::where('name', 'LIKE', '%' . $searchKey . '%')->get();
        return $data;
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => ucwords($value),
        );
    }
}
