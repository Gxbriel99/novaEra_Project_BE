<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssistenceRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'assistence_request'; 

    protected $primaryKey = 'idTicket'; 

    protected $fillable = [
        'email',
        'oggetto',
        'descrizione',
        'allegati'
    ];
}
