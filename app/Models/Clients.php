<?php

namespace App\Models;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    /** @use HasFactory<\Database\Factories\ClientsFactory> */
    use HasFactory;
    protected $table = 'clients';
    protected $fillable = [
        'name',
        'email_address',
        'active',
        
    ];


    protected $hidden = ['remember_token'];

    public function getAuthIdentifierName()
    {
        return 'email_address'; // Use `email_address` for authentication
    }
}
