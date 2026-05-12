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

    // employee_id now references employee_masterlists.id
    public function employee()
    {
        return $this->belongsTo(EmployeeMasterlist::class, 'employee_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
