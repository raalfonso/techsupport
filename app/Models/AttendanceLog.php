<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time',
        'terminal_id',
        'user_id',
        'name',
        'employee_id',
        'class',
        'mode',
        'type',
        'card_serial',
        'result',
        'property',
        'external_device',
        'coordinate'
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

   
}
