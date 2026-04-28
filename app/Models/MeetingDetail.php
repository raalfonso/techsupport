<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingDetail extends Model
{
    protected $fillable = [
        'title',
        'date',
        'time',
        'venue',
        'type_id',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function type()
    {
        return $this->belongsTo(MeetingType::class, 'type_id');
    }

    public function agendas()
    {
        return $this->hasMany(Agenda::class, 'meeting_details_id');
    }

    public function tasks()
    {
        return $this->hasMany(MeetingTask::class, 'meeting_details_id');
    }
}
