<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyReport extends Model
{
    protected $table = 'survey_report';
    protected $fillable = [
        'id',
        'department_id',
        'survey_date',
        'survey_employees_id',
        'accuracy_of_service',
        'response_time',
        'comments',
        'client_name',
        'created_at',
        'updated_at',
    
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }
    public function surveyEmployee()
    {
        return $this->belongsTo(SurveyEmployees::class, 'survey_employees_id');
    }
}
