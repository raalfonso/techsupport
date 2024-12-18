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
        'requestor_name',
        'department_id',
        'issues_id',
        'remarks',
        'status',
        'request_datetime',
        'resolve_datetime',
        'response_datetime',
        'category_id',
        'ticket_number',
        'user_id',
        'location',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Automatically set 'auto_created_at' column to current timestamp
            $model->request_datetime = now(); // You can use `now()` or `Carbon::now()`
            $model->location = "-";
            $model->category_id = $model->issues->category_id;
            if (!$model->ticket_number) {
                $model->ticket_number = substr((string) Guid::uuid4(), 0, 10); // Add custom prefix + UUID
            }
            if (!$model->response_datetime) {
                $model->response_datetime = null;
            }
            if (!$model->resolve_datetime) {
                $model->resolve_datetime = null;
            }
            if (!$model->remarks) {
                $model->remarks = null;
            }
            
            if (!$model->user_id) {
                $model->user_id = null;
            }
            if (!$model->status) {
                $model->status = "Pending";
            }
        });
    }


    public function issues()
    {
        return $this->belongsTo(Issues::class);
    }
}
