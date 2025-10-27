<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Http\Requests\AssistentStoreRequest;
use App\Models\assistenceRequest;
use App\Models\AssistentChat;
use App\Models\AttachmentRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; 
use Exception;
use Illuminate\Routing\Controller; 
use Illuminate\Support\Facades\Log; 
class AssistenceRequestController extends Controller // Assumo che estenda Controller
{
    public function addRequest(AssistentStoreRequest $request)
    {
        // 1. Inizio della transazione
        DB::beginTransaction();

        try {

            $data = $request->validated();
            $attachments = [];

            // --- 1. UTENTE (Crea o trova) ---
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                ['name' => $data['name'], 'surname' => $data['surname']]
            );

            // --- 2. CREAZIONE TICKET (AssistenceRequest) ---
            $assistenceRequest = AssistenceRequest::create([
                'email' => $data['email'],
                'object' => $data['object'],
                'description' => $data['description'],
                'idUser' => $user->idUser,
            ]);

            // --- 3. SALVATAGGIO ALLEGATI ---
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {

                    // Usa il path più specifico e coerente
                    $path = $file->store('private/assistenceRequest/' . $assistenceRequest->idTicket);

                    $attachments[] = AttachmentRequest::create([
                        'idTicket' => $assistenceRequest->idTicket,
                        'fileName' => $file->getClientOriginalName(),
                        'path' => $path,
                        'type' => $file->getClientMimeType(),
                    ]);
                }
            }

            // --- 4. CREA IL TICKET---
            AssistentChat::create([
                'idTicket' => $assistenceRequest->idTicket,
                'idUser' => $user->idUser,
                'message' => $data['description'],
                'response' => null,
                // Prende l'ID dal primo allegato se esiste, altrimenti null
                'idAttachment' => !empty($attachments) ? $attachments[0]->idAttachment : null,
            ]);
            DB::commit();

            //INVIO EMAIL DI CONFERMA ---

            $emailUtente = $data['email'];
            $idTicketCreato = $assistenceRequest->idTicket;

            // Struttura del messaggio
            $oggettoEmail = "Conferma: La tua richiesta di assistenza #{$idTicketCreato} è stata ricevuta";
            $corpoEmail = "Gentile {$data['name']},\n\nAbbiamo ricevuto con successo la tua richiesta di assistenza con ID Ticket: #{$idTicketCreato}.\n\Il nostro team la prenderà in carico a breve e ti risponderà il prima possibile.\n\nGrazie per la pazienza.\n\nCordiali saluti,\nIl Team di Supporto.";

            try {
                // Utilizziamo Mail::raw() per inviare l'email in modo sincrono e immediato
                Mail::raw($corpoEmail, function ($message) use ($emailUtente, $oggettoEmail) {
                    $message->to($emailUtente)
                        ->subject($oggettoEmail);
                });
            } catch (\Throwable $e) {
                // Logga l'errore di invio email, ma non interrompere la risposta HTTP
                Log::error("Errore nell'invio email per ticket #{$idTicketCreato}: " . $e->getMessage());
            }

            // 6. Risposta di Successo
            return response()->json([
                'successo' => true,
                'messaggio' => 'Richiesta registrata con successo. Ticket ID: ' . $assistenceRequest->idTicket
            ], 201);
        } catch (Exception $e) {

            // 7. RILEVAMENTO e Rollback
            DB::rollBack();

            // 8. Risposta di Errore
            return response()->json([
                'successo' => false,
                'errore_dettaglio' => $e->getMessage()
            ], 500);
        }
    }

    
}
