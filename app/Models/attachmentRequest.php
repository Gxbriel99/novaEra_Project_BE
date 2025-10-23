<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttachmentRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'attachment_request';
    protected $primaryKey = 'idAttachment';


    protected $fillable = [
        'idTicket',
        'fileName',
        'path',
        'type'
    ];

    public function ticket()
    {
        return $this->belongsTo(AssistentChat::class, 'idTicket');
    }
}
