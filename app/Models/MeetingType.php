<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MeetingType extends Model
{
    protected $fillable = [
        'title',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function meetingDetails()
    {
        return $this->hasMany(MeetingDetail::class, 'type_id');
    }
}
