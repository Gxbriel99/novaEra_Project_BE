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
    public function allTicketAssistence()
    {
        return AssistenceRequest::all()->select('idTicket', 'object');
    }

    public function allTicket(TicketRequest $request)
    {
        // 1. Ottengo l'email
        $email = $request->validated('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            return [];
        }
        // 3. Ottengo tutti i ticket
        $tickets = $user->tickets()->get();

        // 4. Restituisco i ticket, che ora includono i relativi allegati.
        return $tickets;
    }

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
