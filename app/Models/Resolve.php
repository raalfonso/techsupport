<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resolve extends Model
{
    protected $table = 'resolve';
    protected $fillable = [
        'report_id',
        'user_id',
    
    ];

    public function reportresolve()
    {
        return $this->belongsTo(Report::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
