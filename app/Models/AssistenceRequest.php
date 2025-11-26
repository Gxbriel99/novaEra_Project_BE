<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssistenceRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'email',
        'object',
        'description'
    ];

    public function User() {
        return $this->belongsTo(User::class);
    }
}
