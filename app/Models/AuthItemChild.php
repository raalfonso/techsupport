<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthItemChild extends Model
{
    protected $table = 'auth_item_child';
    protected $fillable = ['parent', 'child'];

    public function parentItem()
    {
        return $this->belongsTo(AuthItem::class, 'parent', 'name');
    }

    public function childItem()
    {
        return $this->belongsTo(AuthItem::class, 'child', 'name');
    }
}
