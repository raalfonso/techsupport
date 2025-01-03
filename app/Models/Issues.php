<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Issues extends Model
{
    /** @use HasFactory<\Database\Factories\IssuesFactory> */
    use HasFactory;

   
    protected $fillable = [
        'title',
        'category_id',
        'mains_id',
        'type',

    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function mains()
    {
        return $this->belongsTo(Main::class);
    }



}
