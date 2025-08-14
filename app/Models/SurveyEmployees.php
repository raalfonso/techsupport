<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyEmployees extends Model
{
    protected $table = 'survey_employees';
    protected $fillable = [
        'name',
        'email',
        'department_id',
        'status',
        'user_survey_id',
        'created_at',
        'updated_at',
    
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
}
