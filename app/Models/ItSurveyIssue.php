<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItSurveyIssue extends Model
{
    protected $fillable = [
        'title',
        'details',
        'other_issues',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function surveys()
    {
        return $this->hasMany(ItSurvey::class, 'issues_id');
    }
}
