<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    use HasFactory, SoftDeletes;

    

    // Campi assegnabili in massa
    protected $fillable = [
        'name',
        'surname',
        'email',
        'created_at',
        'deleted_at'
    ];


    

}
