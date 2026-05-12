<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingAttendee extends Model
{
    protected $fillable = [
        'attendee_id',
        'meeting_detail_id',
    ];

    public function attendee()
    {
        return $this->belongsTo(User::class, 'attendee_id');
    }

    public function meetingDetail()
    {
        return $this->belongsTo(MeetingDetail::class, 'meeting_detail_id');
    }
}
