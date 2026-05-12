<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $fillable = [
        'meeting_details_id',
        'title',
        'details',
        'status',
        'assigned_personnel',
        'remarks',
        'updated_by',
    ];

    public function meetingDetail()
    {
        return $this->belongsTo(MeetingDetail::class, 'meeting_details_id');
    }

    public function updatedByUser()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
