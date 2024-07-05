<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected static $searchable = [
        'expected_at' => 'date_format:Y-m-d H:i:s',
        'status' => 'int'
    ];

    protected $fillable = [
        'name',
        'description',
        'status',
        'expected_at',
    ];

    protected $casts = [
        'expected_at' => 'datetime',
    ];

    public static function isFieldSearchable(string $field): bool
    {
        return key_exists($field, self::$searchable);
    }

    public static function getSearchableFieldValidation(string $field): string
    {
        return self::$searchable[$field];
    }
}
