<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ['key', 'value', 'image', 'type'];

    public $timestamps = true;

    /**
     * Helper to get a setting value by key.
     */
    public static function get(string $key, $default = null)
    {
        return static::where('key', $key)->value('value') ?? $default;
    }

    /**
     * Helper to set/update a setting by key.
     */
    public static function set(string $key, $value, ?string $image = null, string $type = 'text')
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => $value, 'image' => $image, 'type' => $type]
        );
    }
}