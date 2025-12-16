<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    // Table name for this model
    protected $table = 'history';

    // Mass assignable fields
    protected $fillable = [
        'id',
        'report_id',
        'status',
        'action',
        'created_at',
        'performed_by',
    ];

    
    // Relationship with User model - each history record belongs to a user
    public function user()
    {
        return $this->belongsTo(User::class, 'performed_by'); 
    }

    // Relationship with Report model - each history record belongs to a report
    public function reports() 
    {
        return $this->belongsTo(Report::class);
    }

}
