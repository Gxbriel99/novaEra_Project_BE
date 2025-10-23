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
        'object',
        'description'
    ];

    /**
     * Definisce la relazione 1:N tra User e AssistentChat.
     * Un utente può inviare più messaggi nella chat di assistenza.
     */
    public function chats()
    {
        return $this->hasMany(AssistentChat::class, 'idUser', 'id');
    }
}
