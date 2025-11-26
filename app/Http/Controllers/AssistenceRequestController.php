<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssistentStoreRequest;
use App\Models\AssistenceRequest;
use App\Models\AssistentChat;
use App\Models\AttachmentRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class AssistenceRequestController extends Controller
{

    public function createTicket($_, array $req)
    {
        //1 ottengo i dati
        $data = $req['input'];

        //2 li valido e se non vanno bene blocco l'invio
        $validator = Validator::make($data, (new AssistentStoreRequest())->rules());

        if ($validator->fails()) {
            return [
                'success' => false,
                'message' => $validator->errors()->first(),
                'code' => 422
            ];
        }

        // 3 Inizio della transazione
        DB::beginTransaction();

        try {
            // 4 UTENTE (Crea o trova) ---//
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                ['name' => $data['name'], 'surname' => $data['surname']]
            );

            // 5 Ticket (Crea) ---//
            $assistenceRequest = AssistenceRequest::create([
                'object' => $data['object'],
                'email' => $data['email'],
                'description' => $data['description'],
            ]);

            $attachments = [];

            // 6 Salvo possibili allegati ---//
            if (!empty($data['attachments'])) {
                foreach ($data['attachments'] as $file) {
                    $attachments[] = AttachmentRequest::create([
                        'assistence_request_id' => $assistenceRequest->id,
                        'fileName' => $file['file_name'], 
                        'path' => $file['path'],          
                        'type' => $file['type'],
                    ]);
                }
            }

            
            // 7 Inizializzo la chat ---//
            AssistentChat::create([
                'assistence_request_id' => $assistenceRequest->id,
                'user_id' => $user->id,
                'message' => $data['description'],
                'response' => null,
            ]);

           
            DB::commit();

            // 8. Risposta di Successo
            return [
                'success' => true,
                'message' => 'Ticket creato con successo',
                'code'=> 201
            ];
        } catch (Exception $e) {

            // 7. RILEVAMENTO e Rollback
            DB::rollBack();

            // 8. Risposta di Errore
            return [
                'success' => false,
                'message' => $e->getMessage(),
                'code' => 500
            ];
        }
    }
}
