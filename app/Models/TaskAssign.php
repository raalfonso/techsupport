<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskAssign extends Model
{
    protected $fillable = [
        'meeting_task_id',
        'assigned_personnel_id',
        'status',
        'remarks',
    ];

    public function meetingTask()
    {
        return $this->belongsTo(MeetingTask::class, 'meeting_task_id');
    }

    public function assignedPersonnel()
    {
        return $this->belongsTo(User::class, 'assigned_personnel_id');
    }
}
