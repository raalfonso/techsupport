<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemTransaction extends Model
{
    use HasFactory;

    protected $table = 'item_transactions';

    protected $fillable = [
        'request_personnel_id',
        'resource_id',
    ];

    public function requestPersonnel()
    {
        return $this->belongsTo(RequestPersonnel::class);
    }

    public function resource()
    {
        return $this->belongsTo(Resource::class);
    }
}
