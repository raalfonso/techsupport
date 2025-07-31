<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    /** @use HasFactory<\Database\Factories\FeedbackFactory> */
    use HasFactory;

    protected $fillable = [
        'report_id',
        'answer1',
        'answer2',
        'answer3',
        'reason',
        'suggestion',
        
    ];

    public function report()
    {
        return $this->belongsTo(Report::class);
    }
}
