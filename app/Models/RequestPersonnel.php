<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPersonnel extends Model
{
    /** @use HasFactory<\Database\Factories\RequestPersonnelFactory> */
    use HasFactory;

    protected $table = 'request_personnel';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'event_title',
        'requestor_id',
        'start_date_time',
        'end_date_time',
        'point_person',
        'meeting_link',
        'status',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date_time' => 'datetime',
            'end_date_time' => 'datetime',
        ];
    }

    /**
     * Get the user that made the request.
     */
    public function requestor()
    {
        return $this->belongsTo(User::class, 'requestor_id');
    }

    /**
     * Get the resources for this request.
     */
    public function resources()
    {
        return $this->belongsToMany(Resource::class, 'item_transactions', 'request_personnel_id', 'resource_id');
    }

    /**
     * Get the assigned staff for this request.
     */
    public function assignedStaff()
    {
        return $this->belongsToMany(User::class, 'staff_assigned', 'request_personnel_id', 'user_id');
    }
}
