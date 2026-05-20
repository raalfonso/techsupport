<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'resources';

    protected $fillable = [
        'item_name',
        'is_active',
        'created_at',
        'created_by',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function itemTransactions()
    {
        return $this->hasMany(ItemTransaction::class);
    }

    public function requestPersonnel()
    {
        return $this->belongsToMany(RequestPersonnel::class, 'item_transactions', 'resource_id', 'request_personnel_id');
    }
}
