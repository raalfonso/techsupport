<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffAssigned extends Model
{
    use HasFactory;

    protected $table = 'staff_assigned';

    protected $fillable = [
        'user_id',
        'request_personnel_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function requestPersonnel()
    {
        return $this->belongsTo(RequestPersonnel::class);
    }
}
