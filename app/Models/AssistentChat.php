<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssistentChat extends Model
{
    use HasFactory, SoftDeletes;

    
    protected $fillable = [
        'assistence_request_id',
        'user_id',
        'message',
        'response',
        'attachment_request_id',
    ];

    public function attachment()
    {
        return $this->hasMany(AttachmentRequest::class);
    }
}
