<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthItem extends Model
{
    protected $table = 'auth_item';
    protected $fillable = ['name', 'type', 'description', 'rule_name', 'data'];

    public function children()
    {
        return $this->hasMany(AuthItemChild::class, 'parent', 'name');
    }

    public function parents()
    {
        return $this->hasMany(AuthItemChild::class, 'child', 'name');
    }

    public function assignments()
    {
        return $this->hasMany(AuthAssignment::class, 'item_name', 'name');
    }
}
