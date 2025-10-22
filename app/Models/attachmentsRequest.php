<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AttachmentRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'attachments_requests'; 

    protected $fillable = [
        'idTicket',    
        'fileName',    
        'path',        
        'type'        
    ];

    public function assistenceRequest()
    {
        return $this->belongsTo(assistenceRequest::class, 'idTicket', 'idTicket');
    }
}
