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

    ];
}
