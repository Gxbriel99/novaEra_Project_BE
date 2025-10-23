<?php

namespace App\Http\Controllers;

use App\Http\Requests\TicketRequest;
use App\Models\AssistentChat;
use App\Models\User;
use Illuminate\Http\Request;

class UserController
{
    public function allTicket(TicketRequest $request)
    {
        // 1. Ottengo l'email
        $email = $request->validated('email');

        // 2. Cerco l'utente (Eager Loading opzionale se vuoi includere anche i ticket)
        // Ho usato ->where()->firstOrFail() al posto di with() per mantenere la logica precedente
        $user = User::where('email', $email)->firstOrFail();

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
