<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssistentStoreRequest;
use App\Http\Requests\TicketRequest;
use App\Models\AssistenceRequest;
use App\Models\AssistentChat;
use App\Models\User;
use Illuminate\Http\Request;

class UserController
{
    

    public function getTicket(string $id)
    {
        // $id conterrà il valore passato nell'URL (es. '123')

        // Trova il ticket o lancia 404
        $ticket = AssistentChat::findOrFail($id);

        // Carica gli allegati relativi al ticket
        $ticket->load('attachment');

        return $ticket;
    }
}
