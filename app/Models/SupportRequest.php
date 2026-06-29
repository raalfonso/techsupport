<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_title',
        'start_datetime',
        'end_datetime',
        'support_details',
        'meeting_link',
        'status',
        'approved_by',
        'assigned_it_id',
        'approver_remarks',
    ];

    protected $casts = [
        'start_datetime' => 'datetime',
        'end_datetime' => 'datetime',
    ];

    public function requester()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function assignedIt()
    {
        return $this->belongsTo(User::class, 'assigned_it_id');
    }
}
