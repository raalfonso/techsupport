<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Main extends Model
{
    /** @use HasFactory<\Database\Factories\MainFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'details',
    ];

    public $timestamps = true;

    public static function getTypes()
    {
        return [
            'Request' => 'Request',
            'Report' => 'Report',
        ];
    }
}
