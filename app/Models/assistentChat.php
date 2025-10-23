<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssistentChat extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'assistent_chat';
    protected $primaryKey = 'id';


    protected $fillable = [
        'idTicket',
        'idUser',
        'message',
        'response',
        'idAttachment',
    ];

    public function attachment() 
    {
        return $this->hasMany(AttachmentRequest::class, 'idTicket');
    }
}
