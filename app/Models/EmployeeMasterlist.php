<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployeeMasterlist extends Model
{
    protected $fillable = [
        'employee_number',
        'last_name',
        'first_name',
        'middle_name',
        'position',
        'place_of_assignment',
        'department_id',
        'date_hired',
        'employment_status',
        'employment_type',
        'email',
        'remarks',
    ];

    protected $casts = [
        'date_hired' => 'date',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function getFullNameAttribute()
    {
        return trim("{$this->first_name} {$this->middle_name} {$this->last_name}");
    }
}
