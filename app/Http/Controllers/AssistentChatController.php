<?php

namespace App\Http\Controllers;


use App\Http\Requests\ResponseRequest;
use App\Models\AssistentChat;
use App\Models\AttachmentRequest;
use App\Models\AssistenceRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;

class AssistentChatController extends Controller
{
    public function sendResponse(ResponseRequest $request)
    {
        // 1. Inizio della transazione 
        DB::beginTransaction();

        try {

            // --- RACCOLTA DATI ---
            $dati = $request->validated();
            $idTicket = $dati['idTicket'];
            $risposta = $dati['response'];

            // Recupero l'idUser dal ticket 
            $ticket = AssistentChat::findOrFail($idTicket);

            $idUtente = $ticket->idUser;

            if(!$idUtente) throw new Exception('Utente non trovato');
            

            $filesAllegati = $request->file('attachments') ?? [];
            $pathAllegati = 'private/assistenceRequest/' . $idTicket;
            $numeroAllegati = 0;

            // 2. INSERIMENTO RISPOSTA
            AssistentChat::create([
                'idTicket' => $idTicket,
                'idUser'   => $idUtente, 
                'message'  => null,
                'response' => $risposta,
                'idAttachment'=> $ticket->idAttachment
            ]);

            // 3. SALVATAGGIO ALLEGATI
            foreach ($filesAllegati as $file) {

                $pathRelativo = Storage::disk('local')->putFileAs(
                    $pathAllegati,
                    $file,
                    $file->hashName()
                );

                AttachmentRequest::create([
                    'idTicket' => $idTicket,
                    'fileName' => $file->getClientOriginalName(),
                    'path'     => $pathRelativo,
                    'type'     => $file->getMimeType(),
                ]);

                $numeroAllegati++;
            }

            // 4. Conferma (se tutto è andato bene)
            DB::commit();

            // 5. Risposta di Successo
            return response()->json([
                'successo' => true,
                'messaggio' => "Risposta inviata al ticket #{$idTicket}."
            ], 201);
        } catch (Exception $e) {

            // 6. Rollback se qualcosa fallisce
            DB::rollBack();

            // 7. Risposta di Errore
            return response()->json([
                'successo' => false,
                'errore_dettaglio' => $e->getMessage() 
            ], 500);
        }
    }

    public function sendMessage(ResponseRequest $request)
    {
        // 1. Inizio della transazione 
        DB::beginTransaction();

        try {

            // --- RACCOLTA DATI ---
            $dati = $request->validated();

            $idTicket = $dati['idTicket'];
            $message = $dati['message'];

            // Recupero l'idUser dal ticket 
            $ticket = AssistentChat::findOrFail($idTicket);

            $idUtente = $ticket->idUser;

            if (!$idUtente) throw new Exception('Utente non trovato');


            $filesAllegati = $request->file('attachments') ?? [];
            $pathAllegati = 'private/assistenceRequest/' . $idTicket;
            $numeroAllegati = 0;

            // 2. INSERIMENTO RISPOSTA
            AssistentChat::create([
                'idTicket' => $idTicket,
                'idUser'   => $idUtente,
                'message'  => $message,
                'response' => null,
                'idAttachment' => $ticket->idAttachment
            ]);

            // 3. SALVATAGGIO ALLEGATI
            foreach ($filesAllegati as $file) {

                $pathRelativo = Storage::disk('local')->putFileAs(
                    $pathAllegati,
                    $file,
                    $file->hashName()
                );

                AttachmentRequest::create([
                    'idTicket' => $idTicket,
                    'fileName' => $file->getClientOriginalName(),
                    'path'     => $pathRelativo,
                    'type'     => $file->getMimeType(),
                ]);

                $numeroAllegati++;
            }

            // 4. Conferma (se tutto è andato bene)
            DB::commit();

            // 5. Risposta di Successo
            return response()->json([
                'successo' => true,
                'messaggio' => "Risposta inviata al ticket #{$idTicket}."
            ], 201);
        } catch (Exception $e) {

            // 6. Rollback se qualcosa fallisce
            DB::rollBack();

            // 7. Risposta di Errore
            return response()->json([
                'successo' => false,
                'errore_dettaglio' => $e->getMessage()
            ], 500);
        }
    }

    public function allChat(Request $request)
    {
        return AssistentChat::where('idTicket', $request->idTicket)->select('id','message','response','idAttachment')->get();
    }

    
}
