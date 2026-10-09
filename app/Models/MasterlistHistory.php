<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterlistHistory extends Model
{
    protected $table = 'masterlist_histories';

    protected $fillable = [
        'user_id',
        'employee_id',
        'date',
        'reason',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
