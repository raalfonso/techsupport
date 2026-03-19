<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WFHAccomplishment extends Model
{
    protected $table = 'wfh_accomplishment';

    protected $fillable = [
        'employee_id',
        'department_id',
        'accomplishment',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'employee_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
