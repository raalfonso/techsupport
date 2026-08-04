<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class UserSurvey extends Authenticatable
{
    protected $table = 'user_survey';

    protected $fillable = [
        'name',
        'email',
        'password',
        'department_id',
        'status',
        'role',
    ];

    protected $hidden = [
        'password',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function surveyEmployee()
    {
        return  $this->belongsTo(SurveyEmployees::class, 'email', 'email');
    }
}