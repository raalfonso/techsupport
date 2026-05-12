<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItSurvey extends Model
{
    protected $fillable = [
        'issues_id',
        'employee_number',
        'answer_question_1',
        'answer_question_2',
        'answer_question_3',
        'answer_question_4',
        'answer_question_5',
        'suggestion',
        'name',
        'other_issues',
    ];

    public function issue()
    {
        return $this->belongsTo(ItSurveyIssue::class, 'issues_id');
    }

    public function employee()
    {
        return $this->belongsTo(EmployeeMasterlist::class, 'employee_number', 'employee_number');
    }
}
