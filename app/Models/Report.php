<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Guid\Guid;
class Report extends Model
{
    /** @use HasFactory<\Database\Factories\ReportFactory> */
    use HasFactory;

    protected $fillable = [
        'ticket_number',
        'client_id',
        'department_id',
        'location',
        'issues_id',
        'status',
        'procedure',
        'request_datetime',
        'response_by',
        'resolve_by',
        'escalated_to',
        'response_datetime',
        'resolve_datetime',
        'notes',
        'remarks',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Automatically set 'auto_created_at' column to current timestamp
            $model->request_datetime = now(); // You can use `now()` or `Carbon::now()`
           
            
            if (!$model->response_datetime) {
                $model->response_datetime = null;
            }
            if (!$model->resolve_datetime) {
                $model->resolve_datetime = null;
            }
            if (!$model->remarks) {
                $model->remarks = null;
            }
           
            if (!$model->status) {
                $model->status = "Pending";
            }
        });

        static::saved(function ($model) {
            if ($model->ticket_number == null) {
                $model->ticket_number = $model->department->acronym."-".date_format($model->request_datetime,'Y-m-d')."-".$model->id;
                $model->save(); // Save again after modifying the ticket_number
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function resolve()
    {
        return $this->belongsTo(User::class, 'response_by', 'id');
    }

    public function response()
    {
        return $this->belongsTo(User::class, 'response_by', 'id');
    }
    public function issues()
    {
        return $this->belongsTo(Issues::class);
    }



    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function clientname()
    {
        return $this->belongsTo(Clients::class, 'client_id', 'id');
    }



}
