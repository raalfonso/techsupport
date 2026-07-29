<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyGenerated extends Model
{
    use HasFactory;

    protected $table = 'survey_generated';

    protected $fillable = [
        'user_survey_id',
        'generated_code',
        'count',
        'status',
        'usage_limit',
        'client_name'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function userSurvey()
    {
        return $this->belongsTo(UserSurvey::class, 'user_survey_id');
    }

    public function surveyReports()
    {
        return $this->hasMany(SurveyReport::class, 'generated_code', 'generated_code');
    }

}
