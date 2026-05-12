<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthAssignment extends Model
{
    protected $table = 'auth_assignment';
    protected $fillable = ['item_name', 'user_id'];

    public function authItem()
    {
        return $this->belongsTo(AuthItem::class, 'item_name', 'name');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
