<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Signatory extends Model
{
    protected $fillable = [
        'employee_id',
        'position',
        'department_id',
    ];

    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
