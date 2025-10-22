<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'user';
    protected $primaryKey = 'idUser';

    protected $fillable = [
        'email',
        'created_at',
        'deleted_at'
    ];

    public function ruoli()
    {
        return $this->belongsToMany(Role::class, 'user_role', 'idUser', 'idRole');
    }
}
